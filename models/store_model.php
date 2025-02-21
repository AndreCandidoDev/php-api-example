<?php 
    class StoreModel 
    {
        private $conn;
    
        public function __construct($dbConnection) 
        {
            $this->conn = $dbConnection;
        }

        public function getAllStores()
        {
            $query = "SELECT * FROM store";

            $result = $this->conn->query($query);
            
            return $result;
        }

        public function getStoreById($id)
        {
            $query = "SELECT * FROM store WHERE store_id = ?";

            $stmt = $this->conn->prepare($query);
            
            $stmt->bind_param('i', $id);
            
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            return $result;
        }

        public function getDetailedStore($id)
        {            
            $query = "SELECT store.store_id, store.manager_staff_id, staff.first_name, staff.last_name, staff.email, address.address 
            FROM store 
            LEFT JOIN staff on store.store_id = staff.staff_id 
            LEFT JOIN address on store.address_id = address.address_id 
            WHERE store.store_id = ?";
            
            $stmt = $this->conn->prepare($query);
            
            $stmt->bind_param('i', $id);
            
            $stmt->execute();
            
            $result = $stmt->get_result();
            
            return $result;
        }

        public function createStore($data)
        {
            return;
        }

        public function updateStore($id, $data)
        {
            return;
        }

        public function deleteStore($id)
        {
            return;
        }
    }

?>