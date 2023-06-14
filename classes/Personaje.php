<?PHP

class Personaje
{

    protected $id;
    protected $nombre;
    protected $alias;
    protected $biografia;
    protected $creador;
    protected $primera_aparicion;
    protected $imagen;



    /**
     * Devuelve el listado completo de personajes en sistema
     */
    public function lista_completa(): array
    {

        $resultado = [];

        $conexion = (new Conexion())->getConexion();
        $query = "SELECT * FROM personajes";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute();

        $resultado = $PDOStatement->fetchAll();

        return $resultado;
    }

    /**
     * Devuelve los datos de un personaje en particular
     * @param int $id El ID único del personaje 
     */
    public function get_x_id(int $id): ?Personaje
    {
        $conexion = (new Conexion())->getConexion();
        $query = "SELECT * FROM personajes WHERE id = $id";

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
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Get the value of alias
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Devuelve el nombre real de un personaje y si alias entre paréntesis
     * @param boolean $aliasPrimero TRUE en caso de querer el alias como dato principal (Y el nombre verdadero entre paréntesis)
     */
    public function getTitulo($aliasPrimero = FALSE): String
    {
        if ($aliasPrimero) {
            $result = "$this->alias ($this->nombre)";
        } else {
            $result = "$this->nombre ($this->alias)";
        }
        return $result;
    }

    /**
     * Inserta un nuevo personaje a la base de datos
     * @param string $nombre
     * @param string $alias
     * @param string $creador Creador o creadores del personaje, separados por comas
     * @param int $primera_aparicion El año en el que el personaje hizo su primera aparición (4 dígitos)
     * @param string $biografia 
     * @param string $imagen ruta a un archivo .jpg o .png 
     */
    public function insert($nombre, $alias, $creador, $primera_aparicion, $biografia, $imagen)
    {

        $conexion = (new Conexion())->getConexion();
        $query = "INSERT INTO personajes VALUES (NULL, :nombre, :alias, :biografia, :creador, :primera_aparicion, :imagen)";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(
            [
                'nombre' => $nombre,
                'alias' => $alias,
                'biografia' => $biografia,
                'creador' => $creador,
                'primera_aparicion' => $primera_aparicion,
                'imagen' => $imagen,
            ]
        );
    }

    /**
     * Edita los datos de un personaje e la base de datos
     * @param string $nombre
     * @param string $alias
     * @param string $creador Creador o creadores del personaje, separados por comas
     * @param int $primera_aparicion El año en el que el personaje hizo su primera aparición (4 dígitos)
     * @param string $biografia 
     * @param string $imagen ruta a un archivo .jpg o .png 
     */
    public function edit($nombre, $alias, $creador, $primera_aparicion, $biografia, $id)
    {

        $conexion = (new Conexion())->getConexion();
        $query = "UPDATE personajes SET nombre = :nombre, alias = :alias, biografia = :biografia, creador = :creador, primera_aparicion = :primera_aparicion WHERE id = :id";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(
            [
                'id' => $id,
                'nombre' => $nombre,
                'alias' => $alias,
                'biografia' => $biografia,
                'creador' => $creador,
                'primera_aparicion' => $primera_aparicion
            ]
        );
    }

    /**
     * Reemplaza la imagen de un personaje
     * @param string $nombre
     */
    public function reemplazar_imagen($imagen, $id)
    {
        $conexion = (new Conexion())->getConexion();
        $query = "UPDATE personajes SET imagen = :imagen WHERE id = :id";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(
            [
                'id' => $id,
                'imagen' => $imagen
            ]
        );
    }

    /**
     * Elimina esta instancia de la base de datos
     */
    public function delete()
    {
        $conexion = (new Conexion())->getConexion();
        $query = "DELETE FROM personajes WHERE id = ?;";


        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute([$this->id]);
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of creador
     */
    public function getCreador()
    {
        return $this->creador;
    }

    /**
     * Get the value of primera_aparicion
     */
    public function getPrimera_aparicion()
    {
        return $this->primera_aparicion;
    }

    /**
     * Get the value of biografia
     */
    public function getBiografia()
    {
        return $this->biografia;
    }

    /**
     * Get the value of imagen
     */
    public function getImagen()
    {
        return $this->imagen;
    }
}
