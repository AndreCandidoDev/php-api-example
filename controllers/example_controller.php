<?php

require_once __DIR__ . '/../models/example_model.php';

class ExampleController 
{
    private $model;
    
    public function __construct($dbConnection) 
	{
        $this->model = new ExampleModel($dbConnection);
    }

    public function getAll() 
	{
        $result = $this->model->getAll();
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

    public function get($id) 
	{
        $result = $this->model->get($id);

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

	public function create() 
	{
		$data = json_decode(file_get_contents('php://input'), true);

		if (!empty($data['name']) && !empty($data['description'])) 
		{
			$result = $this->model->create($data);

			return $result;
		} 
		else 
		{
			return ['status' => 'error', 'message' => 'Name and description fields are required'];
		}
	}

	public function update($id) 
	{
		$data = json_decode(file_get_contents('php://input'), true);

		if (!empty($data['name']) && !empty($data['description'])) 
		{
			$result = $this->model->update($id, $data);

			return $result;
		} 
		else 
		{
			return ['status' => 'error', 'message' => 'Name and description fields are required'];
		}
	}

	public function delete($id) 
	{
		if (!empty($id)) 
		{
			$result = $this->model->delete($id);

			return $result;
		} 
		else 
		{
			return ['status' => 'error', 'message' => 'Invalid example ID'];
		}
	}

}
?>