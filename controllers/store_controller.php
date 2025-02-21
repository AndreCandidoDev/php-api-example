<?php 
    require_once __DIR__ . '/../models/store_model.php';

    class StoreController
    {
        private $model;
    
        public function __construct($dbConnection) 
        {
            $this->model = new StoreModel($dbConnection);
        }

        public function getAllStores() 
	    {
            $result = $this->model->getAllStores();

            $examples = [];

            if ($result->num_rows > 0) 
            {
                while ($row = $result->fetch_assoc()) 
                {
                    array_push($examples, $row);
                }
                return ['status' => 'success', 'data' => $examples];
            } 
            else
            {
                return ['status' => 'error', 'message' => 'No examples found'];
            }
        }

        public function getStoreById($id) 
        {
            $result = $this->model->getStoreById($id);

            if ($result->num_rows > 0) 
            {
                $example = $result->fetch_assoc();
                return ['status' => 'success', 'data' => $example];
            } 
            else 
            {
                return ['status' => 'error', 'message' => 'Example not found'];
            }
        }

        public function getDetailedStore($id)
        {
            $result = $this->model->getDetailedStore($id);

            $examples = [];

            if ($result->num_rows > 0) 
            {
                while ($row = $result->fetch_assoc()) 
                {
                    array_push($examples, $row);
                }

                return ['status' => 'success', 'data' => $examples];
            } 
            else
            {
                return ['status' => 'error', 'message' => 'No examples found'];
            }
        }
    }

?>