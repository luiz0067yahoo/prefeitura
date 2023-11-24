<?php
    require_once ($base_server_path_files.'/library/functions.php');
	require_once($base_server_path_files.'/mvc/model/estadosDAO.php');
	require_once($base_server_path_files.'/mvc/controller/controller.php');
	class estadosController 
	extends controller
	{
		public function save(){
			echo json_encode(parent::save());		
		}
		public function del(){
			echo json_encode(parent::del());		
		}
		public function find(){
            echo json_encode(parent::find());		
		}
		public function findById($id){
			echo json_encode(parent::findById($id));
		}

		public function __construct(){
	        $params=[];
	        if(emptyParameter(estadosDAO::id))$params[estadosDAO::id]=getParameter(estadosDAO::id);
	        if(arrayKeyExistsParameter(estadosDAO::nome))$params[estadosDAO::nome]=getParameter(estadosDAO::nome);
	        if(issetParameter(estadosDAO::sigla))$params[estadosDAO::sigla]=getParameter(estadosDAO::sigla);
			parent::__construct(new estadosDAO($params));
		}
	}
?>