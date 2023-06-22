<?PHP

class Guionista
{

    protected $id;
    protected $nombre_completo;
    protected $biografia;
    protected $foto_perfil;


    /**
     * Devuelve todos los guoinistas en base
     * @return Guionista[]
     */
    public function lista_completa(): array
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT * FROM guionistas";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute();

        $result = $PDOStatement->fetchAll();
             
        return $result;
    }


    /**
     * Devuelve los datos de un guionista en particular
     * @param int $id El ID único del guionista 
     */
    public function get_x_id(int $id): ?Guionista
    {
        $conexion = Conexion::getConexion();
        $query = "SELECT * FROM guionistas WHERE id = ?";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute([$id]);

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
