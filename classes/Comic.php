<?PHP

class Comic
{

    protected $id;
    protected $personaje_principal;
    protected $serie;
    protected $volumen;
    protected $numero;
    protected $titulo;
    protected $publicacion;
    protected $guionista;
    protected $artista;
    protected $bajada;
    protected $personajes_secundarios;
    protected $personajes_secundarios_ids;
    protected $portada;
    protected $origen;
    protected $editorial;
    protected $precio;

    protected static $createValues =
    [
        'id',
        'volumen',
        'numero',
        'titulo',
        'publicacion',
        'bajada',
        'portada',
        'origen',
        'editorial',
        'precio'
    ];

    /**
     * Inserta un nuevo personaje a la base de datos
     * @param string $nombre
     * @param string $alias
     * @param string $creador Creador o creadores del personaje, separados por comas
     * @param int $primera_aparicion El año en el que el personaje hizo su primera aparición (4 dígitos)
     * @param string $biografia 
     * @param string $imagen ruta a un archivo .jpg o .png 
     */
    public function insert($titulo, $personaje_principal_id, $serie_id, $guionista_id, $artista_id, $volumen, $numero, $publicacion, $origen, $editorial, $bajada, $portada, $precio): int
    {

        //$conexion = Conexion::getConexion();
        $conexion = Conexion::getConexion();
        $query = "INSERT INTO comics VALUES (NULL, :titulo, :personaje_principal_id, :serie_id, :guionista_id, :artista_id, :volumen, :numero, :publicacion, :origen, :editorial, :bajada, :portada, :precio)";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(
            [
                'titulo' => $titulo,
                'personaje_principal_id' => $personaje_principal_id,
                'serie_id' => $serie_id,
                'guionista_id' => $guionista_id,
                'artista_id' => $artista_id,
                'volumen' => $volumen,
                'numero' => $numero,
                'publicacion' => $publicacion,
                'origen' => $origen,
                'editorial' => $editorial,
                'bajada' => $bajada,
                'portada' => $portada,
                'precio' => $precio,
            ]
        );

        return $conexion->lastInsertId();
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
    public function edit($titulo, $personaje_principal_id, $serie_id, $guionista_id, $artista_id, $volumen, $numero, $publicacion, $origen, $editorial, $bajada, $precio, $id)
    {
        $conexion = Conexion::getConexion();
        $query = "UPDATE `comics` SET `titulo` = '$titulo', `personaje_principal_id` = '$personaje_principal_id', `guionista_id` = '$guionista_id',`artista_id` = '$artista_id', `serie_id` = '$serie_id', `volumen` = '$volumen', `numero` = '$numero', `publicacion` = '$publicacion', `origen` = '$origen', `editorial` = '$editorial', `bajada` = '$bajada', `precio` = '$precio' WHERE `comics`.`id` = '$id'
";
        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute();
    }
    public function mapear($comicArray): Comic
    {
        $comic = new self();
        foreach (self::$createValues as $atributo) {
            $comic->{$atributo} = $comicArray[strval($atributo)];
        }
        $comic->guionista = (new Guionista())->get_x_id(intval($comicArray['guionista_id']));
        $comic->artista = (new Artista())->get_x_id(intval($comicArray['artista_id']));
        $comic->serie = (new Serie())->get_x_id(intval($comicArray['serie_id']));
        $comic->personaje_principal = (new Personaje())->get_x_id(intval($comicArray['personaje_principal_id']));
        // $comic->personajes_secundarios = $comicArray['personajes_secundarios'];
        $this->personajes_secundarios_ids []= $comicArray['personajes_secundarios'];
        $PSIds = explode(',', $comicArray['personajes_secundarios']);
        $personajes_secundarios = [];

        if (!empty($PSIds[0])) {
            foreach ($PSIds as $id) {
                $personajes_secundarios[] = (new Personaje())->get_x_id(intval($id));
            }
        }

        $comic->personajes_secundarios = $personajes_secundarios;

        return $comic;
    }
    /**
     * Devuelve el catálgo completo
     *@return Comic[]
     */
    public function catalogo_completo(): array
    {
        //echo "Soy un metodo y me estoy ejecutando, desde adentro de la clase Comic! =D";
        $catalogo = [];

        $conexion = Conexion::getConexion();
        $query = "SELECT comics.*, GROUP_CONCAT(comics_x_personajes.id_personaje) AS personajes_secundarios 
        FROM comics
        LEFT JOIN comics_x_personajes ON comics_x_personajes.id_comic = comics.id
        GROUP BY comics.id";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_ASSOC);
        //$PDOStatement->setFetchMode(PDO::FETCH_CLASS, self::class);
        $PDOStatement->execute();

        while ($result = $PDOStatement->fetch()) {
            $catalogo[] = $this->mapear($result);
        }

        return $catalogo;
    }

    /**
     * Devuelve el catalogo de productos de un personaje en particular
     * @param string $personaje Un string con el nombre del personaje a buscar
     * @return Comic[] Un Array lleno de instancias de objeto Comic.
     */
    public function catalogo_x_personaje(int $personaje_id): array
    {
        $catalogo = [];

        $conexion = Conexion::getConexion();
        $query =             
        "SELECT comics.*, GROUP_CONCAT(comics_x_personajes.id_personaje) AS personajes_secundarios 
        FROM comics LEFT JOIN comics_x_personajes 
        ON comics_x_personajes.id_comic = comics.id 
        WHERE personaje_principal_id = ? 
        GROUP BY comics.id";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_ASSOC);
        $PDOStatement->execute([$personaje_id]);

        //$catalogo = $PDOStatement->fetchAll();
        while ($result = $PDOStatement->fetch()) {
            $catalogo[] = $this->mapear($result);
        }

        return $catalogo;
    }

    /**
     * Devuelve los datos de un producto en particular
     * @param int $idProducto El ID único del producto a mostrar 
     */
    public function producto_x_id(int $idProducto): ?Comic
    {
        $conexion = Conexion::getConexion();
        $query =
            // "SELECT comics.*, GROUP_CONCAT(comics_x_personajes.id_personaje) AS personajes_secundarios 
            // FROM comics LEFT JOIN comics_x_personajes 
            // ON comics_x_personajes.id_comic = comics.id 
            // WHERE personaje_principal_id = ? 
            // GROUP BY comics.id";
            "SELECT comics.*, GROUP_CONCAT(comics_x_personajes.id_personaje) AS personajes_secundarios 
            FROM comics LEFT JOIN comics_x_personajes 
            ON comics_x_personajes.id_comic = comics.id 
            WHERE comics.id = ? 
            GROUP BY comics.id";            

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->setFetchMode(PDO::FETCH_ASSOC);
        $PDOStatement->execute([$idProducto]);
        $result = $this->mapear($PDOStatement->fetch());

        if (!$result) {
            return null;
        }
        return $result;
    }

    /**
     * Devuelve el nombre completo de la edición
     */
    public function nombre_completo(): string
    {
        return $this->getSerie()->getNombre() . " Vol." . $this->volumen . " #" . $this->numero;
    }

    /**
     * Devuelve el precio de la unidad, formateado correctamente
     */
    public function precio_formateado(): string
    {
        return number_format($this->precio, 2, ",", ".");
    }

    /**
     * Esta función devuelve las primeras x palabras de un párrafo 
     * @param int $cantidad Esta es la cantidad de palabras a extraer (Opcional)
     */
    public function bajada_reducida(int $cantidad = 10): string
    {
        $texto = $this->bajada;

        $array = explode(" ", $texto);
        if (count($array) <= $cantidad) {
            $resultado = $texto;
        } else {
            array_splice($array, $cantidad);
            $resultado = implode(" ", $array) . "...";
        }

        return $resultado;
    }

    /**
     * Get the value of personaje
     */
    public function getPersonaje()
    {
        // $personaje = (new Personaje())->get_x_id($this->personaje_principal_id);
        // $nombre = $personaje->getNombre();
        // $alias = $personaje->getAlias();
        //return "$nombre ($alias)";
        return $this->personaje_principal;
    }

    /**
     * Get the value of serie
     */
    public function getSerie()
    {
        //$serie = (new Serie())->get_x_id($this->serie_id);
        //$nombre = $serie->getNombre();
        return $this->serie;
    }

    /**
     * Get the value of volumen
     */
    public function getVolumen()
    {
        return $this->volumen;
    }

    /**
     * Get the value of numero
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Get the value of titulo
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Get the value of publicacion
     */
    public function getPublicacion()
    {
        return $this->publicacion;
    }

    /**
     * Get the value of guion
     */
    public function getGuion()
    {
        //$guionista = (new Guionista())->get_x_id($this->guionista_id);
        //$nombre = $guionista->getNombre();
        return $this->guionista;
    }

    /**
     * Get the value of arte
     */
    public function getArte()
    {
       // $artista = (new Artista())->get_x_id($this->artista_id);
      //  $nombre = $artista->getNombre();
        return $this->artista;
    }

    /**
     * Get the value of bajada
     */
    public function getBajada()
    {
        return $this->bajada;
    }

    /**
     * Get the value of portada
     */
    public function getPortada()
    {
        return $this->portada;
    }

    /**
     * Get the value of precio
     */
    public function getPrecio()
    {
        return $this->precio;
    }



    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of id
     */
    public function getSerie_id()
    {
        return $this->serie->getId();
    }
    /**
     * Get the value of id
     */
    public function getPersonaje_principal_id()
    {
        return $this->personaje_principal->getId();
    }
    public function getGuionista_id()
    {
        return $this->guionista->getId();
    }
    public function getArtista_id()
    {
        return $this->artista->getId();
    }
    public function getOrigen()
    {
        return $this->origen;
    }
    public function getEditorial()
    {
        return $this->editorial;
    }

    public function getPersonajeSecundario()
    {
        return $this->personajes_secundarios;
    }

    /**
     * Crea un vinculo de personajes Secundarios
     * @param int $comic_id
     * @param int $personaje_id
     */
    public function add_personajes_sec($comic_id, $personaje_id)
    {
        $conexion = Conexion::getConexion();
        $query = "INSERT INTO comics_x_personajes VALUES (NULL, :comic_id, :personaje_id)";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(
            [
                'comic_id' => $comic_id,
                'personaje_id' => $personaje_id
            ]
        );
    }

    /**
     * Devuelve un array compuesto po IDs de todos los personajes secundarios
     */
    public function getPersonajes_secundarios_ids(): array
    {
        $result = [];
        echo $this->personajes_secundarios_ids;
        //print_r($this->personajes_secundarios) ;
        //$personajes_secundarios_id = implode(",", $this->personajes_secundarios);
        //print_r($personajes_secundarios_id) ;
        //foreach ($personajes_secundarios_id as $value) {
            //$result[] = $value;
        //}
        return $result;
    }

    /**
     * Vaciar lista de personajes secundarios
     * @param int $comic_id
     */
    public function clear_personajes_sec($comic_id)
    {
        $conexion = Conexion::getConexion();
        $query = "DELETE FROM comics_x_personajes WHERE id_comic = :comic_id";

        $PDOStatement = $conexion->prepare($query);
        $PDOStatement->execute(
            [
                'comic_id' => $comic_id
            ]
        );
    }
}
