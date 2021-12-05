<?php

namespace App\Models;

use CodeIgniter\Model;

class Customer_model extends Model {

	protected $table = 'tbl_customer';

	protected $primaryKey = 'cust_id';

	protected $allowedFields = [
		'cust_id', 'cust_name', 'cust_father_name',
		'cust_mother_name', 'cust_nid_no', 'cust_pr_address',
		'cust_mobile', 'cust_email', 'cust_credit_limit',
		'cust_group_id', 'cust_note'
	];


	protected $validationRules  = [
		'cust_name'  =>  'required|min_length[2]|max_length[100]',
		'cust_pr_address'  =>  'required|min_length[2]|max_length[100]',
		'cust_mobile'  =>  'required|min_length[2]|max_length[100]',
		'cust_group_id'  =>  'required|is_not_unique[tbl_customer_group.cg_id]',
		'cust_credit_limit'  =>  'permit_empty|numeric',
	];

	protected $validationMessages = [
		'cust_name' => [
			'required' => 'Name is required.',
			'min_length' => 'Minimum 2 characters.',
			'max_length' => 'Maximum 100 characters.',
		],
		'cust_pr_address' => [
			'required' => 'Address is required.',
			'min_length' => 'Minimum 2 characters.',
			'max_length' => 'Maximum 100 characters.',
		],
		'cust_mobile' => [
			'required' => 'Mobile No is required.',
			'min_length' => 'Minimum 2 characters.',
			'max_length' => 'Maximum 100 characters.',
		],
		'cust_group_id' => [
			'required' => 'Group is required.',
			'min_length' => 'Minimum 2 characters.',
			'max_length' => 'Maximum 100 characters.',
		],
		'cust_credit_limit' => [
			'numeric' => 'Credit Limit Must be Number',
		],
	];
	//-------------------------------------------------
	public function findAll(int $limit=0, int $offset=0) {
		$builder = $this->builder();
		$builder->select('*');
		$builder->join('tbl_customer_group', 'cg_id = cust_id', 'left');
		$query = $builder->get($limit, $offset);
		return $query->getResult();
	}
	//-------------------------------------------------
	public function find($id = null) {
		$builder = $this->builder();
		$builder->select('*');
		$builder->join('tbl_customer_group', 'cg_id = cust_group_id', 'left');
		$builder->where('tbl_customer.cust_id', $id);
		$query = $builder->get();
		return $query->getRow();
	}

	//-------------------------------------------------
	public function getNewId() {
		$builder = $this->builder();
		$builder->selectMax('cust_id');

		$query = $builder->get();

        if ($query->getNumRows() > 0) {
            $row = $query->getRow();
            $max_id = substr($row->cust_id, 1);
            $new_id = $max_id + 1;
            if ($new_id < 10) {
                $new_id = "C00000" . $new_id;
            } elseif ($new_id < 100) {
                $new_id = "C0000" . $new_id;
            } elseif ($new_id < 1000) {
                $new_id = "C000" . $new_id;
            } elseif ($new_id < 10000) {
                $new_id = "C00" . $new_id;
            } elseif ($new_id < 100000) {
                $new_id = "C0" . $new_id;
            } else {
                $new_id = "C" . $new_id;
            }
            return $new_id;
		} else {
			return "C000001";
		}
	}
	//-------------------------------------------------
}
