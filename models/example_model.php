<?php

class ExampleModel {
    private $conn;
    
    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function getAll() {
        $query = "SELECT * FROM examples";
        $result = $this->conn->query($query);
        return $result;
    }

    public function get($id) {
        $query = "SELECT * FROM examples WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    public function create($data) {
		$query = "INSERT INTO examples (name, description) VALUES (?, ?)";
		$stmt = $this->conn->prepare($query);
		$stmt->bind_param('ss', $data['name'], $data['description']);

		if ($stmt->execute()) {
			return ['status' => 'success', 'message' => 'Foi criado com sucesso'];
		} else {
			return ['status' => 'error', 'message' => 'Erro ao criar'];
		}
	}

	public function update($id, $data) {
		$query = "UPDATE examples SET name = ?, description = ? WHERE id = ?";
		$stmt = $this->conn->prepare($query);
		$stmt->bind_param('ssi', $data['name'], $data['description'], $id);

		if ($stmt->execute()) {
			return ['status' => 'success', 'message' => 'Foi atualizado com sucesso'];
		} else {
			return ['status' => 'error', 'message' => 'Erro ao atualizar'];
		}
	}

	public function delete($id) {
		$query = "DELETE FROM examples WHERE id = ?";
		$stmt = $this->conn->prepare($query);
		$stmt->bind_param('i', $id);

		if ($stmt->execute()) {
			return ['status' => 'success', 'message' => 'Foi deletado com sucesso'];
		} else {
			return ['status' => 'error', 'message' => 'Erro ao deletar'];
		}
	}
}
?>