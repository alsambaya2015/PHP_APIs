<?php
class Project{
 
    // database connection and table name
    private $conn;
    private $table_name = "projects";
 
    // object properties
    public $id;
    public $name;
    public $description;
    public $author;
    public $country;
    public $date_created;
 
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read products
    function read(){
 
        // select all query
        $query = "SELECT
                    id, name, description, author, country
                FROM
                    " . $this->table_name . " 
                ORDER BY
                    name";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;      
    }
    // create product
      function create(){
       
          // query to insert record
          $query = "INSERT INTO
                      " . $this->table_name . "
                    SET
                      name=:name, author=:author, description=:description, country=:country, date_created=:date_created";
       
          // prepare query
          $stmt = $this->conn->prepare($query);
       
          // sanitize
          $this->name=htmlspecialchars(strip_tags($this->name));
          $this->author=htmlspecialchars(strip_tags($this->author));
          $this->description=htmlspecialchars(strip_tags($this->description));
          $this->country=htmlspecialchars(strip_tags($this->country));
          $this->date_created=htmlspecialchars(strip_tags($this->date_created));
       
          // bind values
          $stmt->bindParam(":name", $this->name);
          $stmt->bindParam(":author", $this->author);
          $stmt->bindParam(":description", $this->description);
          $stmt->bindParam(":country", $this->country);
          $stmt->bindParam(":date_created", $this->date_created);
       
          // execute query
          if($stmt->execute()){
              return true;
          }
       
          return false;   
      }
        // used when filling up the update product form
        function readOne(){
        
            // query to read single record
            $query = "SELECT
                         id, name, description, author, country
                    FROM
                        " . $this->table_name . "            
                    WHERE
                        id = ?";                       
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
        
            // bind id of product to be updated
            $stmt->bindParam(1, $this->id);
        
            // execute query
            $stmt->execute();
        
            // get retrieved row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
            // set values to object properties
            $this->name = $row['name'];
            $this->author = $row['author'];
            $this->description = $row['description'];
            $this->country = $row['country'];        
        }
        // update the product
        function update(){
        
            // update query
            $query = "UPDATE
                        " . $this->table_name . "
                    SET
                        name = :name,
                        author = :author,
                        description = :description,
                        country = :country
                    WHERE
                        id = :id";
        
            // prepare query statement
            $stmt = $this->conn->prepare($query);
        
            // sanitize
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->author=htmlspecialchars(strip_tags($this->author));
            $this->description=htmlspecialchars(strip_tags($this->description));
            $this->country=htmlspecialchars(strip_tags($this->country));
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            // bind new values
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':author', $this->author);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':country', $this->country);
            $stmt->bindParam(':id', $this->id);
        
            // execute the query
            if($stmt->execute()){
                return true;
            }
        
            return false;
        }

}
?>