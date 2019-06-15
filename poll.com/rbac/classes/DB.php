<?php
// database PDO singleton (get instance static)
class DB {
    private static $_instance = null;
    private $_pdo, //true если объект PDO создан
            $_query, // посленний выполненный запрос
            $_error = false, // ошибка выполнения запроса
            $_results, // в эту переменную записываются результаты запроса
            $_count = 0; // количество переданных из базы результатов запроса
    private function __construct() { // пытается соединиться и отловить ошибку, private - чтобы не было доступа вне singleton PDO
        try {
                        $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'),Config::get('mysql/username'), Config::get('mysql/password'));
            //echo 'connected';
        } catch(PDOexception $e) {
            die($e->getMessage());
        }
    }

    // проверяет, создан ли уже объект DB, обеспечивая работу singleton
   public static function getInstance() {
                if(!isset(self::$_instance)) {
                        self::$_instance = new DB();
                }
                return self::$_instance;
        }

    public function query($sql, $params = array()) {
        $this->_error = false; // обнуляет ошибку от предыдущего запроса
        if($this->_query = $this->_pdo->prepare($sql)) {
            $x = 1;
            if(count($params)) {
                foreach($params as $param) {
                    $this->_query->bindValue($x, $param); // привязывает параметры к позиции, $x = "?" в запросе, ему присваивается значение $param
                    $x++;
                }
            }
            if($this->_query->execute()) { // выполнение запроса, сохраненного в _query
                $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ); // возвращает сразу объект а не массив
                $this->_count = $this->_query->rowCount(); // функция PDO для подсчета запросов
            } else {
                $this->_error = true;
            }
        }

        return $this;
    }

    // методы формирования запросов
    public function action($action, $table, $where = array()) {
            if(count($where) == 3) { // 3 элемента запроса WHERE: 'username', '=', 'anna'
            $operators = array('=', '>', '<', '>=', '<=');

            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];

            if(in_array($operator, $operators)) { // если оператор в запросе (массиве) есть и соответствует элементу $operators
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?"; // значение '?' будет привязано через bindValue()
                if(!$this->query($sql, array($value))->error()) { // здесь вместо '?' подставится значение $value из $operators
                    return $this;
                }
            }

        }
        return false;
    }

    public function get($table, $where) {
        // например, $user = DB::getInstance()->get('users', array('username', '=', 'anna'));
        // здесь $table = 'users' и $where = array(), запрашиваемые методом get()
        return $this->action('SELECT *', $table, $where);
        
    }

    public function delete($table, $where) {
        return $this->action('DELETE', $table, $where);

    }

    public function insert($table, $fields = array()) {
        if(count($fields)) {
            $keys = array_keys($fields);
            $values = '';
            $x = 1;

            foreach($fields as $field) {
                $values .= '?'; // вместо ? будет передано значение $fields из параметров query() ниже
                if($x < count($fields)) {
                    $values .= ', '; // просле каждого переданного параметра ставит разделитель по $x++
                }
                $x++;
            }

            $sql = "INSERT INTO users (`" . implode('`, `', $keys) . "`) VALUES ({$values})";
            // первая и последняя ` оборачивают начало и конец выражения, а разделительные ` генерятся через implode()

           if(!$this->query($sql, $fields)->error()) {
                return true;
           }
        }
        return false;
    }

    public function update($table, $id, $fields) {
        $set = '';
        $x = 1;

        foreach($fields as $name => $value) {
            $set .= "{$name} = ?";
            if($x < count($fields)) {
                $set .= ',';
            }
            $x++;
        }

        $sql = "UPDATE {$table} SET {$set} WHERE id= {$id}";

        if(!$this->query($sql, $fields)->error()) {
            return true;
        }

        return false;
    }

    public function results() {
        return $this->_results;
    }

    public function first() {
        return $this->results()[0]; // возвращает только первый результат запроса
    }

    public function error() {
        return $this->_error;
    }

    public function count() {
        return $this->_count;
    }
}