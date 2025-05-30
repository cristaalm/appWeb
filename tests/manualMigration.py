import mysql.connector
from mysql.connector import Error


def migrar_datos_codigos_postales():
    try:
        # Configuración de la conexión a la base de datos
        connection = mysql.connector.connect(
            host="localhost",
            database="test",
            user="root",
            password="",
        )

        if connection.is_connected():
            cursor = connection.cursor()

            # Variables para estadísticas
            total_migrados = 0
            total_errores = 0
            batch_size = 1  # Hacer commit cada 1000 registros
            errores_detalle = []

            # Consulta para obtener los datos de la tabla origen
            select_query = """
            SELECT id_colonia, clave_colonia, codigo_postal, nombre_colonia, estatus 
            FROM _cat_colonias
            ORDER BY id_colonia
            """

            # Consulta para insertar en la tabla destino
            insert_query = """
            INSERT INTO _cat_neighborhoods 
            (`key`, postal_code, name, status)
            VALUES (%s, %s, %s, %s);
            """

            cursor.execute(select_query)
            registros = cursor.fetchall()

            total = len(registros)
            print(f"Total de registros a migrar: {total}")

            for i, (
                id_colonia,
                clave_colonia,
                codigo_postal,
                nombre_colonia,
                estatus,
            ) in enumerate(registros, 1):
                try:
                    # Función para limpiar valores manteniéndolos como strings
                    def clean_string(value):
                        if value is None:
                            return None
                        try:
                            # Convertir a string sin conversión automática a números
                            return str(value).strip() or None
                        except:
                            return None

                    # Preparar todos los valores como strings
                    valores = (
                        clean_string(clave_colonia),  # postal_code (string)
                        clean_string(codigo_postal),  # state_id (string)
                        clean_string(nombre_colonia),  # municipalities_id (string)
                        estatus,  # status (string)
                    )

                    # print(
                    #     f"Procesando registro {i}/{total} - {clave_colonia}, {codigo_postal}, {nombre_colonia}, {estatus}"
                    # )

                    # Insertar registro
                    cursor.execute(insert_query, valores)
                    total_migrados += 1

                    # Hacer commit periódicamente
                    if i % batch_size == 0:
                        connection.commit()
                        print(f"Commit: {i}/{total} registros procesados...")

                except Error as e:
                    error_msg = f"Error en registro {i}: CP={clave_colonia} - {str(e)}"
                    print(error_msg)
                    errores_detalle.append(error_msg)
                    total_errores += 1
                    connection.rollback()  # Revertir solo esta operación
                    continue

            # Commit final para los registros restantes
            connection.commit()

            # Reporte final
            print(f"\nMigración completada.")
            print(f"Total registros procesados: {total}")
            print(f"Migrados exitosamente: {total_migrados}")
            print(f"Registros con errores: {total_errores}")

            if errores_detalle:
                with open("errores_migracion.txt", "w") as f:
                    f.write("\n".join(errores_detalle))
                print("\nDetalles de errores guardados en 'errores_migracion.txt'")

    except Error as e:
        print("\nError crítico durante la migración:", e)
        if "connection" in locals() and connection.is_connected():
            connection.rollback()
    finally:
        if "connection" in locals() and connection.is_connected():
            cursor.close()
            connection.close()
            print("Conexión a MySQL cerrada.")


if __name__ == "__main__":
    migrar_datos_codigos_postales()
