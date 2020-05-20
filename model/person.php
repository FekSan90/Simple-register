<?php

/**
 * Class person
 * Az adatbázisban lévő Person táblát valósítja meg a program szintjén
 * és az ehhez tartozó műveleteket.
 */

require_once(__DIR__ . '\model.php');

class person
{
    /**
     *  Elsődleges kulcs
     * @var
     */
    private $id;
    /**
     * A személy neve
     * @var
     */
    private $name;
    /**
     * A személy születési dátuma
     * @var
     */
    private $birthdate;
    /**
     * A személy neme
     * @var
     */
    private $gender;


    /**
     * person constructor.
     * @param $id
     * @param null $name
     * @param null $birthdate
     * @param null $gender
     */
    public function __construct($id, $name = NULL, $birthdate = NULL, $gender = NULL)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setBirthdate($birthdate);
        $this->setGender($gender);
    }


    /**
     * Kilistázza egy tömbbe az adatbázis elmeit.
     * @return array|null
     */
    public static function fetchAll()
    {
        $result = null;
        $model = new model();
        if (!is_null($model)) {
            $sql = 'SELECT * FROM ' . config::PERSON_TABLE . ' ORDER BY id';
            $table = $model->pdo->query($sql);
            foreach ($table as $row) {
                $result[] = new person($row['id'], $row['name'], $row['birthdate'], $row['gender']);
            }
        }
        return $result;
    }


    /**
     * A létrehozott elemet kitörli az adatbáziból.
     * @return bool
     */
    public function delete()
    {
        $result = false;
        $sql = "DELETE FROM " . config::PERSON_TABLE . " WHERE id=?";
        $model = new model();
        if (!is_null($model)) {
            $stmt = $model->pdo->prepare($sql);
            $stmt->bindValue(1, $this->id);
            $result = $stmt->execute();
        }
        return $result;
    }


    /**
     * A létrehozott elemere módosítja az adabázisban lévőt
     * elsődleges kulcs szerint azonosítva.
     * @return bool
     */
    public function update()
    {
        $result = false;
        $sql = "UPDATE " . config::PERSON_TABLE .
            "  SET name=?," .
            "      birthdate=?," .
            "      gender=?" .
            "  WHERE id=?";
        $model = new model();
        if (!is_null($model)) {
            $stmt = $model->pdo->prepare($sql);
            $stmt->bindValue(1, $this->name);
            $stmt->bindValue(2, $this->birthdate);
            $stmt->bindValue(3, $this->gender);
            $stmt->bindValue(4, $this->id);
            $result = $stmt->execute();
        }
        return $result;
    }


    /**
     * A létrhozott személyt beszúrja az adatbázisba.
     * @return bool
     */
    public function insert()
    {
        $result = false;
        if (!$this->is_exist()) {
            $sql = "INSERT INTO " . config::PERSON_TABLE .
                " (name, birthdate, gender)" .
                " VALUES (?,?,?);";

            $nextid = "select nextval('id_seq');";

            $model = new model();
            if (!is_null($model)) {
                $stmt = $model->pdo->prepare($sql);
                $stmt->bindValue(1, $this->name);
                $stmt->bindValue(2, $this->birthdate);
                $stmt->bindValue(3, $this->gender);
                $result = $stmt->execute();
                $model->pdo->query($nextid);
            }
        }
        return $result;
    }

    /**
     * Lekéri a legutobbi elsődleges kulccsal szinkronban számláló változó értékét
     * ezt eggyel nővelve adja vissza.
     * @return int
     */
    public static function nextId()
    {
        $result = 1;

        $sql = "select last_value  FROM id_seq" .
            " WHERE is_called;";

        $model = new model();
        if (!is_null($model)) {
            $stmt = $model->pdo->prepare($sql);
            $stmt->execute();
            $fetch = $stmt->fetch();
            if (is_countable($fetch)) {
                $result = $fetch[0] + 1;
            }
        }
        return $result;
    }

    /**
     * Ellenörzi, hogy a létrehozott személy benne szerepel-e az adatbázisban.
     * @return bool
     */
    private function is_exist()
    {
        $model = new model();
        if (!is_null($model)) {

            $sql = "SELECT * FROM " . config::PERSON_TABLE . "
                    WHERE name='" . $this->name . "' AND  
                          birthdate ='" . $this->birthdate . "' AND
                          gender='" . $this->gender . "'";

            $stmt = $model->pdo->prepare($sql);
            $stmt->execute();
            $rowCount = $stmt->rowCount();
            if ($rowCount == 0) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param mixed $id
     */
    private
    function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public
    function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public
    function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public
    function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public
    function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * @param mixed $birthdate
     */
    public
    function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }

    /**
     * @return mixed
     */
    public
    function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public
    function setGender($gender)
    {
        $this->gender = $gender;
    }
}
