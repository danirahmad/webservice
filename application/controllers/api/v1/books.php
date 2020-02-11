<?php

require_once APPPATH . 'Libraries/REST_Controller.php';
use Restserver\libraries\REST_Controller;

class books extends REST_Controller {
    function __construct($config = 'rest'){
        parent :: __construct($config);
    }

    function books_get(){
        $id = $this->get('id');

        if($id){
            $book = $this->db->get_where('books',
            array('id_books' => $id))->result();
        }else{
            $book = $this->db->get('books')->result();
        }

        //response
        if($book){
            $this->response($book, 200);
        }else{
            $this->response(array('status' => 'not found'), 404);
        }
    }

    function books_post(){
        $params = array(
            'name' => $this->post('name'),
            'year' => $this->post('year'),
            'id_authors' => $this->post('id_authors'));
        $process = $this->db->insert('books', $params);

        // response
        if($process){
            $this->response(array('status' => 'succes'), 201);
        }else{
            return $this->response(array('status' => 'failed'), 502);
        }
    }

    function books_put(){
        $params = array(
            'name' => $this->put('name'),
            'year' => $this->put('year'),
            'id_authors' => $this->put('id_authors'));
        $this->db->where('id_books', $this->put('id'));
        $execute = $this->db->update('books', $params);

        // response
        if($execute){
            $this->response(array('status' => 'succes'), 201);
        }else{
            return $this->response(array('status' => 'failed'), 502);
        }
    }

    function books_delete(){
        $this->db->where('id_books', $this->delete('id'));
        $execute = $this->db->delete('books');

        // response
        if($execute){
            $this->response(array('status' => 'succes'), 201);
        }else{
            return $this->response(array('status' => 'failed'), 502);
        }
    }
}