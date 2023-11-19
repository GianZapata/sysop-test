<?php
namespace Model;

use PDO;

class ActiveRecord {

    // Database properties
    protected static $pdo;
    protected static $table = '';
    protected static $primaryKey = '';
    protected static $dbColumns = [];

    // Define the DB connection
    public static function setDB($pdo) {
        self::$pdo = $pdo;
    }

    // SQL Query to create an object in memory
    public static function consultSQL($query, $params = [] ) {
        // Consultar la base de datos

        $statement = self::$pdo->prepare($query);
        $statement->execute(  $params );
        $result = $statement->fetchAll();
        
        // Iterar los resultados
        $array = [];
        foreach ($result as $registro) {
            $array[] = static::createObject($registro);
        }
        
        // liberar la memoria
        $statement->closeCursor();

        // retornar los resultados
        return $array;
    }

    // Create the object in memory
    protected static function createObject($record) {
        $object = new static;

        foreach($record as $key => $value) {
            if(property_exists($object, $key)) {
                $object->$key = $value;
            }
        }
        return $object;
    }

    // Identify and merge the DB attributes
    public function attributes() {
        $attributes = [];
        foreach(static::$dbColumns as $column) {
            if($column === static::$primaryKey) continue;
            $attributes[$column] = $this->$column;
        }

        return $attributes;
    }

    // Sanitize the data before saving to the DB
    public function sanitizeAttributes() {
        $attributes = $this->attributes();
        $sanitized = [];

        
        foreach($attributes as $key => $value) {
            $sanitized[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        return $sanitized;
    }

    // Synchronize DB with objects in memory
    public function synchronize($args = []) {
        foreach($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    // Records - CRUD
    public function save() {
        if(!is_null($this->{static::$primaryKey})) {
            return $this->update();
        } else {
            return $this->create();
        }
    }

    // Get all records
    public static function all( $columns = ['*'] ) {
        $columns = implode(', ', $columns);                                 
        $query = "SELECT {$columns} FROM " . static::$table;
        $result = self::consultSQL($query);
        return $result;
    }

    // Find a record by its primary key
    public static function find($id) {
        $query = "SELECT * FROM " . static::$table . " WHERE " . static::$primaryKey . " = ?";
        $result = self::consultSQL($query, [ $id ]);
        return array_shift($result);
    }

    // Get records with a certain limit
    public static function get($limit) {
        $query = "SELECT * FROM " . static::$table . " ORDER BY " . static::$primaryKey . " DESC LIMIT ?";
        $result = self::consultSQL($query, [ $limit ]);
        return $result;
    }

    // Search Where with column
    public static function where($column, $value) {
        $query = "SELECT * FROM " . static::$table . " WHERE {$column} = ?";
        $result = self::consultSQL($query, [ $value ]);
        return $result;
    }
    
    public static function whereFirst($column, $value) {
        $query = "SELECT * FROM " . static::$table . " WHERE {$column} = ? LIMIT 1";
        $result = self::consultSQL($query, [ $value ]);
        return array_shift($result);
    }

    // Create a new record
    public function create() {
        $attributes = $this->sanitizeAttributes();

        $fields = implode(', ', array_keys($attributes));
        $values = ':' . implode(', :', array_keys($attributes));
        $query = "INSERT INTO " . static::$table . " ({$fields}) VALUES ({$values})";

        $statement = self::$pdo->prepare($query);
        
        $attributesArray = [];
        foreach ($attributes as $key => $value) {
            $attributesArray[":{$key}"] = "{$value}";
        }

        $result = $statement->execute($attributesArray);
        
        $this->{static::$primaryKey} = self::$pdo->lastInsertId();

        $statement->closeCursor();

        return $result;
    }

    // Update the record
    public function update(): array {
        // Sanitizar los datos
        $attributes = $this->attributes();

        // Iterar para ir agregando cada campo de la BD
        $values = [];
        $attributesArray = [];        
        $attributesArray[":" . static::$primaryKey] = $this->{static::$primaryKey};

        foreach($attributes as $key => $value) {
            $values[] = "{$key} = :{$key}";
            $attributesArray[":{$key}"] = "{$value}";
        }

        // Consulta SQL
        $query = "UPDATE " . static::$table ." SET ";
        $query .=  join(', ', $values );
        $query .= " WHERE " . static::$primaryKey ." = :" . static::$primaryKey;
        $query .= " LIMIT 1 "; 

        // Actualizar BD
        $statement = self::$pdo->prepare($query);
        $statement->execute($attributesArray);
        $result = $statement->fetchAll();
        return $result;
    }

    // Delete a record by its primary key
    public function delete(): bool {
        $query = "DELETE FROM "  . static::$table . " WHERE " . static::$primaryKey ." = :" . static::$primaryKey;        
        $result = self::$pdo->prepare($query);        
        $result->execute([":" . static::$primaryKey => $this->{static::$primaryKey}]);
        return $result->rowCount() > 0;
    }
}
