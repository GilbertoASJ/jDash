<?php 
	
// Classe Dashboard
class Dashboard {

	public $dataInicio;
	public $dataFim;

	public $numeroVendas;
	public $totalVendas;

	public function __get($attr) {

		return $this->$att;
	}

	public function __set($attr, $value) {

		$this->$attr = $value;

		return $this;
	}
}

// Classe Conexão com o banco de dados
class Conexao {

	private $host = 'localhost';
	private $dbname = 'dashboard';
	private $user = 'root';
	private $password = '';

	public function conectar() {

		try {

			$conexao = new PDO(
				"mysql:host=$this->host;dbname=$this->dbname", 
				"$this->user",
				"$this->password"
			);

			// Atribuindo collection utf-8 para a aplicação
			$conexao->exec('set charset utf8');

			return $conexao;

		} catch(PDOException $e) {

			echo "<p> $e->getMessage() </p>";
		}
	}
}

// Classe model
class Bd {

	private $conexao;
	private $dashboard;

	public function __construct(Conexao $conexao, Dashboard $dashboard) {

		$this->conexao = $conexao->conectar();
		$this->dashboard = $dashboard;
	}

	public function getNumeroVendas() {

		$query = "SELECT 
					COUNT(*) as numeroVendas 
				FROM 
					tb_vendas 
				WHERE 
					data_venda BETWEEN :dataInicio AND :dataFim ";

		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':dataInicio', '2021-02-15');
		$stmt->bindValue(':dataFim', '2021-04-04');

		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_OBJ);
	}
}

// Instânciando as classes

$dashboard = new Dashboard();
$conexao = new Conexao();

$bd = new Bd($conexao, $dashboard);
echo "<pre>"; 
	print_r($bd->getNumeroVendas());
echo "</pre>";

?>