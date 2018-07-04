<?php

require(APPPATH.'/libraries/REST_Controller.php');
 
class Api extends REST_Controller{
    
    public function __construct()
    {
        parent::__construct();

        $this->load->model('calificaciones_model');
    }

   
     
    //API - create a new book item in database.
    function addcalificacion_post(){
        $id_t_materias      = $this->post('id_t_materias');
        $id_t_usuarios     = $this->post('id_t_usuarios');
        $calificacion    = $this->post('calificacion');
        $fecha_registro  = $this->post('fecha_registro');
        $myObj =  new stdClass();

       
        if(!$id_t_materias || !$id_t_usuarios || !$calificacion || !$fecha_registro ){

               $this->response("Ingresar Informacion Completa", 400);

        }else{

           $result = $this->calificaciones_model->add(array("id_t_materias"=>$id_t_materias, "id_t_usuarios"=>$id_t_usuarios, "calificacion"=>$calificacion, "fecha_registro"=>$fecha_registro));

           if($result === 0){

               $this->response("Ocurrio un Error Intente Nuevamente", 404);

           }else{

            $myObj->success = "ok";
            $myObj->msg = 'calificacion registrada';

            $this->response( json_encode($myObj)) ;

              // $this->response();  
          
           }

       }

    }

    function calificaciones_get () { 

        $id_alumno = $this->get('id_alumno');

        $result = $this->calificaciones_model->get_calificaion($id_alumno); 
       

        $prom = 0;
        $mat = 0;
        for ($i=0; $i < count($result); $i++) { 
            $prom = $prom + $result[$i]['calificacion'];
            $mat++;
        }
        
        $promedio = $prom / $mat;
        array_push($result,array('Promedio'=>$promedio));

        $res = json_encode($result);
     
        if ($result) { 
     
           $this->response($res, 200); 
     
        } else { 
     
           $this->response("No se encontró registro", 404); 
     
        }
     
     }


     function update_put(){
         
        $id_t_materias      = $this->put('id_t_materias');
        $id_t_usuarios     = $this->put('id_t_usuarios');
        $calificacion    = $this->put('calificacion');
        $fecha_registro  = $this->put('fecha_registro');
        $id_t_calificaciones        = $this->put('id_t_calificaciones');
        
        if(!$id_t_materias || !$id_t_usuarios || !$calificacion || !$fecha_registro ){

               $this->response("Ocurrio un error al actualizar", 400);

        }else{
           $result = $this->calificaciones_model->update($id_t_calificaciones, array("id_t_materias"=>$id_t_materias, "id_t_usuarios"=>$id_t_usuarios, "calificacion"=>$calificacion, "fecha_registro"=>$fecha_registro));

           if($result === 0){

               $this->response("Book information coild not be saved. Try again.", 404);

           }else{

            $myObj->success = "ok";
            $myObj->msg = 'calificacion actualizada';

            $this->response( json_encode($myObj)) ;


           }

       }

   }


   function deletecal_delete()
    {

        $id  = $this->delete('id_t_calificaciones');
    
        if(!$id){

            $this->response("Parameter missing", 404);

        }
         
        if($this->calificaciones_model->delete($id))
        {

            $myObj->success = "ok";
            $myObj->msg = 'calificacion eliminada';

            $this->response( json_encode($myObj)) ;

        } 
        else
        {

            $this->response("Failed", 400);

        }

    }
   



}