<?php

namespace App\Controllers;

use App\Models\ModelHewanAir;

class HewanAir extends BaseController
{
    public function index()
    {
        return view('HewanAir/tampilhewan');
    }

    public function ambildata()
    {
        if ($this->request->isAJAX()) {
            $mhs = new ModelHewanAir();
            $data = [
                'tampildata' => $mhs->findAll()
            ];
            $msg = [
                'data' => view('HewanAir/datahewan', $data) // Tambahkan $ sebelum data
            ];
            echo json_encode($msg);
        } else {
            exit('maaf tidak dapat diproses');
        }
    }

    public function formtambah()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'id' => '',
                'nama' => '',
                'habitat' => '',
                'pola_makan' => '',
                'status' => ''
            ];
            $msg = [
                'data' => view('HewanAir/tambahhewan', $data)
            ];
            echo json_encode($msg);
        } else {
            exit('maaf tidak dapat diproses');
        }
    }

    public function simpandata()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'id' => [
                    'label' => 'ID',
                    'rules' => 'required|is_unique[hewan_air.id]',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong',
                        'is_unique' => '{field} Tidak Boleh Ada Yang Sama,silahkan coba yang lain',
                    ]
                ],
                'nama' => [
                    'label' => 'NAMA HEWAN',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong',
                    ]
                ],
                'habitat' => [
                    'label' => 'Habitat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong',
                    ]
                ],
                'pola_makan' => [
                    'label' => 'Pola Makan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong',
                    ]
                ],
                'status' => [
                    'label' => 'Status',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} Tidak Boleh Kosong',
                    ]
                ],

            ]);

            if (!$valid) {
                $msg = [
                    'error' => [
                        'id' => $validation->getError('id'),
                        'nama' => $validation->getError('nama'),
                        'habitat' => $validation->getError('habitat'),
                        'pola_makan' => $validation->getError('pola_makan'),
                        'status' => $validation->getError('status'),
                    ]
                ];
                echo json_encode($msg);
            } else {
                //tambahkan logika untuk menyimpan data di sini
                $simpandata = [
                    'id' => $this->request->getPost('id'),
                    'nama' => $this->request->getPost('nama'),
                    'habitat' => $this->request->getPost('habitat'),
                    'pola_makan' => $this->request->getPost('pola_makan'),
                    'status' => $this->request->getPost('status'),
                ];
                $mhs = new ModelHewanAir();
                $mhs->insert($simpandata);

                $msg = [
                    'success' => 'Data HewanAir berhasil disimpan'
                ];
                echo json_encode($msg);
            }
        } else {
            exit('maaf tidak dapat diproses');
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {
            $id_hewan = $this->request->getVar('id_hewan');

            $mhs = new ModelHewanAir();
            $row = $mhs->find($id_hewan);
            $data = [
                // sebelah kanan field pada tabel HewanAir
                'id_hewan' => $row['id_hewan'],
                'id' => $row['id'],
                'nama' => $row['nama'],
                'habitat' => $row['habitat'],
                'pola_makan' => $row['pola_makan'],
                'status'  => $row['status'],
            ];
            $msg = [
                'sukses' => view('HewanAir/modalhewan', $data)
            ];

            echo json_encode($msg);
        }
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            // jika benar/valid
            $simpandata = [
                'id' => $this->request->getPost('id'),
                'nama' => $this->request->getPost('nama'),
                'habitat' => $this->request->getPost('habitat'),
                'pola_makan' => $this->request->getPost('pola_makan'),
                'status' => $this->request->getPost('status'),
            ];

            $mhs = new ModelHewanAir();
            $id_hewan = $this->request->getVar('id_hewan');
            $mhs->update($id_hewan, $simpandata);

            $msg = [
                'sukses' => 'Data Hewan Air Berhasil di Update !!'
            ];
            echo json_encode($msg);
        } else {
            exit('Maaf tidak dapat di proses');
        }
    }


    public function hapus()
    {
        if ($this->request->isAJAX()) {
            // jika benar/valid



            $id_hewan = $this->request->getVar('id_hewan');
            $mhs = new ModelHewanAir();
            $mhs->delete($id_hewan);

            $msg = [
                'sukses' => 'Data Hewan Air Berhasil di Hapus !!'
            ];
            echo json_encode($msg);
        }
    }
}
