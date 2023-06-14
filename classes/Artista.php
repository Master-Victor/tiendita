<?PHP

class Artista
{

    protected $id;
    protected $nombre_completo;
    protected $biografia;
    protected $foto_perfil;


    /**
     * Devuelve todos los artistas en base
     * @return Artista[]
     */
    public function lista_completa(): array
    {
        $conexion = (new Conexion())->getConexion();
        $query = "SELECT * FROM artistas";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute();

        $result = $PDOStatement->fetchAll();

        return $result;
    }

    /**
     * Devuelve los datos de un artista en particular
     * @param int $id El ID único del artista 
     */
    public function get_x_id(int $id): ?Artista
    {
        $conexion = (new Conexion())->getConexion();
        $query = "SELECT * FROM artistas WHERE id = $id";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute();

        $result = $PDOStatement->fetch();

        if (!$result) {
            return null;
        }
        return $result;
    }

    /**
     * Get the value of nombre_completo
     */
    public function getNombre()
    {
        return $this->nombre_completo;
    }

    /**
     * Get the value of biografia
     */
    public function getBiografia()
    {
        return $this->biografia;
    }

    /**
     * Get the value of foto_perfil
     */
    public function getImagen()
    {
        return $this->foto_perfil;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }
}
