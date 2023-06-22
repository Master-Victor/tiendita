<?PHP

class Conexion
{

    public const DB_SERVER = 'localhost';
    //public const DB_SERVER = '127.0.0.1';
    public const DB_USER = 'root';
    public const DB_PASS = '';
    public const DB_NAME = 'tiendita';

    public const DB_DSN = 'mysql:host=' . self::DB_SERVER . ';dbname=' . self::DB_NAME . ';charset=utf8mb4';

    /**
     * Esta propiedad es te tipo PDO
     */
    protected static ?PDO $db = null;

    private static function conectar()
    {

        try {
            self::$db = new PDO(self::DB_DSN, self::DB_USER, self::DB_PASS, array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              ));
              
        } catch (Exception $e) {
            die('Error al conectar con MySQL.');
        }
    }

    /**
     * Función que devuelve una conexión PDO lista para usar
     * @return PDO
     */
    public static function getConexion(): PDO
    {
        if(self::$db == null){
            self::conectar();
        }

        return self::$db;
    }
}
