<?php

namespace App\Models;

use CodeIgniter\Model;

class Product_unit_model extends Model {

	protected $table = 'tbl_product_unit';

	protected $primaryKey = 'unit_id';

	protected $allowedFields = [
		'unit_id', 'unit_name', 'unit_note'
	];

	protected $validationRules  = [
		'unit_name' => 'required|min_length[2]|max_length[100]',
	];

	protected $validationMessages = [
		'unit_name' => [
			'required' => 'Unit name is required.',
			'min_length' => 'Minimum 2 characters.',
			'max_length' => 'Maximum 100 characters.',
		],
	];
	//-------------------------------------------------
	public function findProdUnitByIdOrName($str_search) {
		if (isset($str_search)) {
			$builder = $this->builder();
			$builder->select('unit_id as data, unit_name as value');
			$builder->like('unit_id' , $_REQUEST['query']);
			$builder->orLike('unit_name' , $_REQUEST['query']);
			$query = $builder->get();

		} else {
			$builder = $this->builder();
			$builder->select('unit_id as data, unit_name as value');
			$query = $builder->get();
		}
		return $query;
	}
	//-------------------------------------------------
	public function getNewId() {
		$builder = $this->builder();
		$builder->selectMax('unit_id');

		$query = $builder->get();

		if ($query->getNumRows() > 0) {
			$row = $query->getRow();
			$max_id = substr($row->unit_id, 2);
			$new_id = $max_id + 1;
			if ($new_id < 10) {
				$new_id = "PU00000" . $new_id;
			} elseif ($new_id < 100) {
				$new_id = "PU0000" . $new_id;
			} elseif ($new_id < 1000) {
				$new_id = "PU000" . $new_id;
			} elseif ($new_id < 10000) {
				$new_id = "PU00" . $new_id;
			} elseif ($new_id < 100000) {
				$new_id = "PU0" . $new_id;
			} else {
				$new_id = "PU" . $new_id;
			}
			return $new_id;
		} else {
			return "PU000001";
		}
	}
	//-------------------------------------------------
}
