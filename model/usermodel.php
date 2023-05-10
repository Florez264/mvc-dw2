<?php


class UserModel extends Model implements IModel{

    private $id;
    private $username;
    private $password;
    private $photo;
    private $role;
    private $name;

    function __construct(){
        parent::__construct();

         $this->username  ='';
         $this->password  ='';
         $this->photo     ='';
         $this->role      ='';
         $this->name      ='';
    }
    public function save(){
        try {
            $query = $this->prepare('INSERT INTO users(username, password, photo, role, name) VALUES(:username, :password, :photo, :role, :name)');
            $query -> execute([
                'username' => $this->username,
                'password' => $this->password,
                'photo'    => $this->photo,
                'role'     => $this->role,
                'name'     => $this->name
            ]) ;
            
            return true;
        } catch (PDOException $e) {
            error_log('USERMODEL::save->PDOException' . $e);
            return false;
        }
    }

    public function getall(){
        $items = [];
        try {
            $query = $this->query('SELECT * FROM users');
            while ($p = $query->fetch(PDO::FETCH_ASSOC)) {
                $item = new UserModel();
                $item->setId($p['id']);
                $item->setUsername($p['username']);
                $item->setPassword($p['password'], false);
                $item->setPhoto($p['photo']);
                $item->setRole($p['role']);
                $item->setName($p['name']);

                array_push($items, $item);
            }
            return $items;


        } catch (PDOException $e) {
            error_log('USERMODEL::getall -> PDOException' . $e);
        }
    }
    public function get($id){

        try {
            $query = $this->prepare('SELECT * FROM users WHERE id = :id');
            $query -> execute([
                'id' => $id
            ]);

            $user = $query->fetch(PDO::FETCH_ASSOC);
            
                $this->setId($user['id']);
                $this->setUsername($user['username']);
                $this->setPassword($user['password'], false);
                $this->setPhoto($user['photo']);
                $this->setRole($user['role']);
                $this->setName($user['name']);

                
         
            return $this;


        } catch (PDOException $e) {
            error_log('USERMODEL::getall -> PDOException' . $e);
        }
    }
    public function delete($id){

        try{
            $query = $this->prepare('DELETE FROM users WHERE id = :id');
            $query->execute([ 'id' => $id]);
            return true;
        }catch(PDOException $e){
            error_log('USERMODEL::delete -> PDOException' . $e);
            return false;
        }
    }

    public function update(){
        try {
            $query = $this->prepare('UPDATE users SET username = :username, password = :password, photo = :photo, name = :name WHERE id = :id');
            $query -> execute([
                'id'       => $this->id,
                'username' => $this->username,
                'password' => $this->password,
                'photo'    => $this->photo,
                'name'     => $this->name
            ]);        
         
            return true;


        } catch (PDOException $e) {
            error_log('USERMODEL::update -> PDOException' . $e);
            return false;
        }
    }

    public function from($array){

        $this->id       = $array['id'];
        $this->username = $array['username'];
        $this->password = $array['password'];
        $this->role     = $array['role'];
        $this->photo    = $array['photo'];
        $this->name     = $array['name'];
    }

    public function exists($username){
        try{
            $query = $this->prepare('SELECT username FROM users WHERE username = :username');
            $query->execute( ['username' => $username]);
            
            if($query->rowCount() > 0){
                return true;
            }else{
                return false;
            } 
        }catch(PDOException $e){
            error_log('USERMODEL::exists -> PDOException' . $e);
            return false;
        }
    }
 
    function comparePasswords($current, $userid){
        try{

            $query = $this->db->conexion()->prepare('SELECT id, password FROM users WHERE id = :id');
            $query->execute(['id' => $userid]);
            
            if($row = $query->fetch(PDO::FETCH_ASSOC)) return password_verify($current, $row['password']);

            return NULL;
        }catch(PDOException $e){
            return NULL;
        }
    }

    /**Funciones para el metodo SET */
    public function setId($id){   $this->id = $id;}

    public function setUsername($username){   $this->username = $username;}

    //FIXME: validar si se requiere el parametro de hash
    public function setPassword($password, $hash = true){ 
        if($hash){
            $this->password = $this->getHashedPassword($password);
        }else{
            $this->password = $password;
        }
    }
    private function getHashedPassword($password){
        return password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]);
    }

    public function setPhoto($photo){         $this-> photo = $photo;}

    public function setRole($role){           $this->role =  $role;}

    public function setName($name){           $this->name = $name;}

    /**funciones para el metodo GET */
    public function getId(){         return $this->id;}
 
    public function getUsername(){   return $this->username;}

    public function getPassword(){   return $this->password;}

    public function getPhoto(){      return $this->photo;}

    public function getRole(){       return $this->role;}

    public function getName(){       return $this->name;}

    
}

?>