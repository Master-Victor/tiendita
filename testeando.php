<?PHP 

    class Animal{
        protected $edad;
        public function hacerSonido(){
            echo "El animal va a hacer sonido";
        }
    }
    //herencia
    class Gato extends Animal{
        
        protected $raza;
        public function hacerSonido(){
            echo "Maullar";
            $this->edad = 20;
        }
    }

    class Perro extends Animal{
        public function hacerSonido()
        {
            echo "ladrar";
            $this->edad = 30;
        }
    }

    function hacerSonidoAnimal(Animal $mascota){
        echo $mascota->hacerSonido();
    }
    
    //polimorfismo
    hacerSonidoAnimal(new Gato());
    hacerSonidoAnimal(new Perro());

    