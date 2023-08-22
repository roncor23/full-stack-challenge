<?php

namespace Otto;

class Challenge
{
    protected $pdoBuilder;

    public function __construct()
    {
        $config = require __DIR__ . '/../config/database.config.php';
        $this->setPdoBuilder(new PdoBuilder($config));
    }

    /**
     * Use the PDOBuilder to retrieve all the records
     *
     * @return array
     */
    public function getRecords() 
    {
        $pdo = $this->getPdoBuilder()->getPdo();
    
        $query = "
            SELECT b.id, b.name,
                   d.first_name, d.last_name, b.registered_address, b.registration_number
            FROM businesses AS b
            JOIN director_businesses AS db ON b.id = db.business_id
            JOIN directors AS d ON db.director_id = d.id
        ";
        
        $stmt = $pdo->query($query);
        
        return $stmt->fetchAll();
    }

    /**
     * Use the PDOBuilder to retrieve all the director records
     *
     * @return array
     */
    public function getDirectorRecords() 
    {
        $pdo = $this->getPdoBuilder()->getPdo();
    
        $query = "SELECT * FROM directors";
        $stmt = $pdo->query($query);
        
        return $stmt->fetchAll();
    }

    /**
     * Use the PDOBuilder to retrieve a single director record with a given id
     *
     * @param int $id
     * @return array
     */
    public function getSingleDirectorRecord($id)
    {
        $pdo = $this->getPdoBuilder()->getPdo();
    
        $query = "SELECT * FROM directors WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    /**
     * Use the PDOBuilder to retrieve all the business records
     *
     * @return array
     */
    public function getBusinessRecords() 
    {
        $pdo = $this->getPdoBuilder()->getPdo();
    
        $query = "SELECT * FROM businesses";
        $stmt = $pdo->query($query);
        
        return $stmt->fetchAll();
    }

    /**
     * Use the PDOBuilder to retrieve a single business record with a given id
     *
     * @param int $id
     * @return array
     */
    public function getSingleBusinessRecord($id) 
    {

        $pdo = $this->getPdoBuilder()->getPdo();
    
        $query = "SELECT * FROM businesses WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    /**
     * Use the PDOBuilder to retrieve a list of all businesses registered on a particular year
     *
     * @param int $year
     * @return array
     */
    public function getBusinessesRegisteredInYear($year)
    {
        $pdo = $this->getPdoBuilder()->getPdo();
    
        $query = "SELECT * FROM businesses WHERE YEAR(registration_date) = :year";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':year', $year, \PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    /**
     * Use the PDOBuilder to retrieve the last 100 records in the directors table
     *
     * @return array
     */
    public function getLast100Records()
    {
        $pdo = $this->getPdoBuilder()->getPdo();
    
        $query = "
            SELECT id, first_name, last_name, occupation, date_of_birth
            FROM directors
            ORDER BY id DESC
            LIMIT 100
        ";
        
        $stmt = $pdo->query($query);
        
        return $stmt->fetchAll();
    }

    /**
     * Use the PDOBuilder to retrieve a list of all business names with the director's name in a separate column.
     * The links between directors and businesses are located inside the director_businesses table.
     *
     * Your result schema should look like this;
     *
     * | business_name | director_name |
     * ---------------------------------
     * | some_company  | some_director |
     *
     * @return array
     */
    public function getBusinessNameWithDirectorFullName()
    {
        $pdo = $this->getPdoBuilder()->getPdo();
    
        $query = "
            SELECT b.name AS business_name, CONCAT(d.first_name, ' ', d.last_name) AS director_name
            FROM businesses AS b
            JOIN director_businesses AS db ON b.id = db.business_id
            JOIN directors AS d ON db.director_id = d.id
        ";
        
        $stmt = $pdo->query($query);
        
        return $stmt->fetchAll();
    }

    /**
     * @param PdoBuilder $pdoBuilder
     * @return $this
     */
    public function setPdoBuilder(PdoBuilder $pdoBuilder)
    {
        $this->pdoBuilder = $pdoBuilder;
        return $this;
    }

    /**
     * @return PdoBuilder
     */
    public function getPdoBuilder()
    {
        return $this->pdoBuilder;
    }
}
