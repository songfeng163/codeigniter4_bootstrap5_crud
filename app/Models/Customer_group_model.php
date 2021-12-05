<?php

namespace App\Models;

use CodeIgniter\Model;

class Customer_group_model extends Model {

	protected $table = 'tbl_customer_group';

	protected $primaryKey = 'cg_id';

	protected $allowedFields = [
		'cg_id', 'cg_name', 'cg_note'
	];

	//-------------------------------------------------
	public function findCustGroupByIdOrName($str_search) {
		if (isset($str_search)) {
			$builder = $this->builder();
			$builder->select('cg_id as data, cg_name as value');
			$builder->like('cg_id' , $_REQUEST['query']);
			$builder->orLike('cg_name' , $_REQUEST['query']);
			$query = $builder->get();

		} else {
			$builder = $this->builder();
			$builder->select('cg_id as data, cg_name as value');
			$query = $builder->get();
		}
		return $query;
	}
	//-------------------------------------------------
	public function getNewId() {
		$builder = $this->builder();
		$builder->selectMax('cg_id');

		$query = $builder->get();

		if ($query->getNumRows() > 0) {
			$row = $query->getRow();
			$max_id = substr($row->cg_id, 2);
			$new_id = $max_id + 1;
			if ($new_id < 10) {
				$new_id = "CG00000" . $new_id;
			} elseif ($new_id < 100) {
				$new_id = "CG0000" . $new_id;
			} elseif ($new_id < 1000) {
				$new_id = "CG000" . $new_id;
			} elseif ($new_id < 10000) {
				$new_id = "CG00" . $new_id;
			} elseif ($new_id < 100000) {
				$new_id = "CG0" . $new_id;
			} else {
				$new_id = "CG" . $new_id;
			}
			return $new_id;
		} else {
			return "CG000001";
		}
	}
	//-------------------------------------------------
}
