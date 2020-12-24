<?php
defined('BASEPATH') or exit('No direct script access allowed');

/* Model Code Author : Fitra Arrafiq */
class M_Pengajuan_izin extends CI_Model
{
	public function getAllData($username)
	{
		$this->datatables->select('i.id_izin, p.nama, i.lama_izin, i.tgl_mulai, i.tgl_akhir, i.jadwal_off, i.acc_kaunit, i.ket_kaunit, i.acc_kabid, i.ket_kabid, i.acc_kabid_sdm, i.ket_sdm, i.bukti_izin, ji.jenis_izin, ji.jenis_izin');
		$this->datatables->from('izin i');
		$this->datatables->join('pegawai p', 'p.id_pegawai = i.id_pegawai', 'left');
		$this->datatables->join('jenis_izin ji', 'ji.id_jenis_izin = i.id_jenis_izin', 'left');
		$this->datatables->join('staff s', 's.id_staff = p.id_staff', 'left');
		$this->datatables->where('s.username', $username);
		$this->datatables->where('i.status = 1');
		return $this->datatables->generate();
	}

	// fungsi mengambil seluruh data pada tabel izin utk ditampilkan pada
	// kaunit, kabid dan kabid_sdm
	public function getAllData1()
	{
		$this->datatables->select('i.id_izin, p.nama, i.lama_izin, i.tgl_mulai, i.tgl_akhir, i.jadwal_off, i.acc_kaunit, i.ket_kaunit, i.acc_kabid, i.ket_kabid, i.acc_kabid_sdm, i.ket_sdm, i.bukti_izin, ji.jenis_izin, ji.jenis_izin');
		$this->datatables->from('izin i');
		$this->datatables->join('pegawai p', 'p.id_pegawai = i.id_pegawai', 'left');
		$this->datatables->join('jenis_izin ji', 'ji.id_jenis_izin = i.id_jenis_izin', 'left');
		$this->datatables->join('staff s', 's.id_staff = p.id_staff', 'left');
		// $this->datatables->where('s.username', $username);
		$this->datatables->where('i.status = 1');
		return $this->datatables->generate();
	}

	public function getData()
	{
		$this->db->select('*');
		$this->db->from('izin');
		$this->db->order_by('id_izin', 'desc');
		return $this->db->get()->result();
	}

	public function getJenisIzinByUsername($username)
	{
		$this->db->select('ji.id_jenis_izin, ji.jenis_izin, ji.lama_izin');
		$this->db->from('izin i');
		$this->db->join('pegawai p', 'p.id_pegawai = i.id_pegawai', 'left');
		$this->db->join('staff s', 's.id_staff = p.id_staff ', 'left');
		$this->db->join('jenis_izin ji', 'ji.id_jenis_izin = i.id_jenis_izin', 'left');
		$this->db->where('s.username', $username);
		return $this->db->get()->result();
	}

	public function getByIdJenisIzin($id_jenis_izin)
	{
		$this->db->select('*');
		$this->db->from('jenis_izin');
		$this->db->where('id_jenis_izin', $id_jenis_izin);
		return $this->db->get()->result();
	}

	public function getIdStaff($idStaff)
	{
		$this->db->select('id_staff');
		$this->db->from('pegawai');
		$this->db->where('id_staff', $idStaff);
		return $this->db->get()->result();
	}

	public function getPegawaiByUsernameStaff($username)
	{
		$this->db->select('p.id_pegawai,p.nama,p.id_staff,s.username');
		$this->db->from('pegawai p');
		$this->db->join('staff s', 's.id_staff = p.id_staff', 'left');
		$this->db->where('s.username', $username);
		return $this->db->get()->result();
	}

	public function getJenisIzin()
	{
		$this->db->select('*');
		$this->db->from('jenis_izin');
		$this->db->order_by('id_jenis_izin', 'desc');
		return $this->db->get()->result();
	}

	public function getDataStaff($username)
	{
		$this->db->select('*');
		$this->db->from('staff');
		$this->db->where('username', $username);
		return $this->db->get()->result();
	}

	public function getKodeIzin()
	{
		$q = $this->db->query("select MAX(RIGHT(id_izin,1000)) as id_izin from izin");
		$kd = "";
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $k) {
				$tmp = ((int) $k->id_izin) + 1;
				$kd = sprintf("%03s", $tmp);
			}
		} else {
			$kd = "001";
		}
		return "PI-" . $kd;
	}

	public function getKodeIzin1()
	{
		$q = $this->db->query("select MAX(RIGHT(id_izin,9)) as id_izin from izin");
		$kd = "";
		if ($q->num_rows() > 0) {
			foreach ($q->result() as $k) {
				$tmp = ((int) $k->id_izin) + 1;
				$kd = sprintf("%09s", $tmp);
			}
		} else {
			$kd = "000000001";
		}
		return "PI-" . $kd;
	}


	public function getPegawai()
	{
		$this->db->select('*');
		$this->db->from('pegawai');
		$this->db->order_by('id_pegawai', 'desc');
		return $this->db->get()->result();
	}

	public function addData($data)
	{
		$this->db->insert('izin', $data);
		return $this->db->affected_rows() > 0 ? $this->db->insert_id() : FALSE;
	}

	function simpan_upload($bukti_izin,  $id_pegawai, $lama_izin, $tgl_mulai, $tgl_akhir, $jadwal_off, $acc_kaunit, $ket_kaunit, $acc_kabid, $ket_kabid, $acc_kabid_sdm, $ket_sdm, $status, $id_jenis_izin)
	{
		// $data['id_izin']       = $id_izin;
		$data['id_pegawai']       = $id_pegawai;
		$data['lama_izin'] = $lama_izin;
		$data['tgl_mulai']        = $tgl_mulai;
		$data['tgl_akhir']      = $tgl_akhir;
		$data['jadwal_off']        = $jadwal_off;
		$data['acc_kaunit']        = $acc_kaunit;
		$data['ket_kaunit']        = $ket_kaunit;
		$data['acc_kabid']        = $acc_kabid;
		$data['ket_kabid']        = $ket_kabid;
		$data['acc_kabid_sdm']        = $acc_kabid_sdm;
		$data['ket_sdm']        = $ket_sdm;
		$data['bukti_izin']        = $bukti_izin;
		$data['status']        = $status;
		$data['id_jenis_izin']        = $id_jenis_izin;
		$result              = $this->db->insert('izin', $data);
		return $result;
	}

	public function updateStatus($id)
	{
		// $this->_deleteImage($id);
		return $this->db->query("update izin set status = 2 where id_izin =" . $id);
	}

	public function get_by_id($id)
	{
		return $this->db->get_where('izin ap', array('ap.id_izin' => $id))->result();
	}

	public function getById($id)
	{
		$this->db->select('*');
		$this->db->from('izin');
		$this->db->where('id_izin', $id);
		return $this->db->get()->row();
	}

	public function getById1($id)
	{
		$this->db->select('i.id_izin, i.id_pegawai, i.lama_izin as izin_lama, i.tgl_mulai, i.tgl_akhir, i.jadwal_off, i.acc_kaunit, i.ket_kaunit, i.acc_kabid, i.ket_kabid, i.acc_kabid_sdm, i.ket_sdm, i.bukti_izin,i.status,i.id_jenis_izin,ji.id_jenis_izin, ji.jenis_izin, ji.lama_izin, ji.lokasi');
		$this->db->from('izin i');
		$this->db->join('jenis_izin ji', 'ji.id_jenis_izin = i.id_jenis_izin', 'left');
		$this->db->where('i.id_izin', $id);
		return $this->db->get()->row();
	}

	public function getByIdUpload($id)
	{
		$this->db->select('i.id_izin, i.bukti_izin, i.id_pegawai, p.nama');
		$this->db->from('izin i');
		$this->db->join('pegawai p', 'p.id_pegawai = i.id_pegawai', 'left');
		$this->db->where('i.id_izin', $id);
		return $this->db->get()->row();
	}

	public function updateGbr($id, $data)
	{
		$this->_deleteImage($id);

		return $this->db->query('update izin set bukti_izin = "' . $data . '" where id_izin = ' . $id);
	}

	function update($id, $data)
	{
		$this->db->where('id_izin', $id);
		$this->db->update('izin', $data);
		return $this->db->affected_rows();
	}


	private function _deleteImage($id)
	{
		$data = $this->get_by_id($id);
		$filename = explode(".", $data[0]->bukti_izin)[0];
		return array_map('unlink', glob(FCPATH . "bukti_izin/$filename.*"));
	}

	function delete($id)
	{
		$this->_deleteImage($id);
		$this->db->where('id_izin', $id);
		$this->db->delete('izin');
	}
}

/* End of file M_Pengajuan_izin.php */
