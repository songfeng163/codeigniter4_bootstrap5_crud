<?php

namespace App\Models;

use CodeIgniter\Model;

class Vendor_model extends Model {

	protected $table = 'tbl_vendor';

	protected $primaryKey = 'ven_id';

	protected $allowedFields = [
		'ven_id', 'ven_name', 'ven_org', 'ven_addr', 'ven_mobile', 'ven_email', 'ven_note'
	];

	protected $validationRules  = [
		'ven_name' => 'required|min_length[2]|max_length[100]',
		'ven_mobile' => 'required|min_length[2]|max_length[100]',
	];

	protected $validationMessages = [
		'ven_name' => [
			'required' => 'Vendor name is required.',
			'min_length' => 'Minimum 2 characters.',
			'max_length' => 'Maximum 100 characters.',
		],
		'ven_mobile' => [
			'required' => 'Mobile is required.',
			'min_length' => 'Minimum 2 characters.',
			'max_length' => 'Maximum 100 characters.',
		],
	];
	//-------------------------------------------------
	public function findVendorByIdOrName($str_search) {
		if (isset($str_search)) {
			$builder = $this->builder();
			$builder->select('ven_id as data, ven_name as value');
			$builder->like('ven_id' , $_REQUEST['query']);
			$builder->orLike('ven_name' , $_REQUEST['query']);
			$query = $builder->get();

		} else {
			$builder = $this->builder();
			$builder->select('ven_id as data, ven_name as value');
			$query = $builder->get();
		}
		return $query;
	}
	//-------------------------------------------------
	public function getNewId() {
		$builder = $this->builder();
		$builder->selectMax('ven_id');

		$query = $builder->get();

		if ($query->getNumRows() > 0) {
			$row = $query->getRow();
			$max_id = substr($row->ven_id, 1);
			$new_id = $max_id + 1;
			if ($new_id < 10) {
				$new_id = "V00000" . $new_id;
			} elseif ($new_id < 100) {
				$new_id = "V0000" . $new_id;
			} elseif ($new_id < 1000) {
				$new_id = "V000" . $new_id;
			} elseif ($new_id < 10000) {
				$new_id = "V00" . $new_id;
			} elseif ($new_id < 100000) {
				$new_id = "V0" . $new_id;
			} else {
				$new_id = "V" . $new_id;
			}
			return $new_id;
		} else {
			return "V000001";
		}
	}
	//-------------------------------------------------
}
