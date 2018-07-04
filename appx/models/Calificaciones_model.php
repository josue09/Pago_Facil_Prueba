<?php
  class Calificaciones_model extends CI_Model {
       
      public function __construct(){
          
        $this->load->database();
        
      }
      
   
   //API call - add new book record
    public function add($data){

        if($this->db->insert('t_calificaciones', $data)){

           return true;

        }else{

           return false;

        }

    }

    public function get_calificaion($id_alumno){   

     $consulta = $this->db->select('t_al.id_t_usuarios,t_al.nombre ,t_al.ap_paterno,t_mat.nombre materia,t_cal.calificacion , t_cal.fecha_registro');
     $consulta = $this->db->join('t_materias t_mat','t_cal.id_t_materias = t_mat.id_t_materias','left');
     $consulta = $this->db->join('t_alumnos t_al','t_cal.id_t_usuarios = t_al.id_t_usuarios','left');
     $consulta = $this->db->where('t_al.id_t_usuarios',$id_alumno);
     $consulta = $this->db->get('t_calificaciones t_cal');

      if($consulta->num_rows() > 0){

        return $consulta->result_array();

      }else{

        return 0;

      }

  }


  public function update($id, $data){

    $this->db->where('id_t_calificaciones', $id);

    if($this->db->update('t_calificaciones', $data)){

       return true;

     }else{

       return false;

     }

 }


 public function delete($id){

  $this->db->where('id_t_calificaciones', $id);

  if($this->db->delete('t_calificaciones')){

     return true;

   }else{

     return false;

   }

}
   
    }

