<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index(){

		$this->load->helper('url');

		$data['slist'] =  $this->db->get('row_column')->result();

		$data['lists'] =  $this->db->group_by('style_id')->get('price_style')->result();

		$this->load->view('welcome_message',$data);

	}


	public function save_style(){

		$style_name = $this->input->post('name');

		$data = array(
		 	'style_name'=>$style_name,
		 	'create_data_time'=>date('Y-m-d H:i:s'),
		 	'create_by'=>1
		);

		$this->db->insert('row_column',$data);
		echo 1;
	}


	public function save(){

		$getData = $this->input->post('row');
		$getStyle_id = $this->input->post('style_id');
		$style_id = time();

		if(!empty($getStyle_id)){

			$this->db->where('style_id',$getStyle_id)->delete('price_style');
			$this->db->where('style_id',$getStyle_id)->delete('price_chaild_style');
		}
		

        foreach ($getData as $key => $value) {

            $rowData[] = explode(',', $value);
           
        }

        $colData = array();
		
        $j = 0;
        foreach ($rowData as $row => $columns) {

			$j++;
            $i = 0;
			//$columns[$i]."<br>";
			$rss='';
            foreach ($columns as $row2 => $column2) {
				$i++;
                
				if($j>1){

					if(!empty($_POST['test1'.$j]) && !empty($_POST['test'.$i."1"])){
        				$priceData[] = array(
							'style_id'=>(!empty($getStyle_id)?$getStyle_id:$style_id),
							'row'=>$_POST['test'.$i."1"],
							'col'=>$_POST['test1'.$j],
							'price'=>$_POST['test'.$i.$j]
						);
					}				

				}
				$rss .= $_POST['test'.$i.$j].',';

            } 

			$price_chaildData[] = array('style_id' =>(!empty($getStyle_id)?$getStyle_id:$style_id),'row'=>rtrim($rss,','));


        }

        $this->db->insert_batch('price_style',$priceData);
        $this->db->insert_batch('price_chaild_style',$price_chaildData);

		
	}


	public function edit($id){

		$data = $this->db->where('style_id',$id)->get('price_chaild_style')->result();
		$table='';
		$i=1;

		foreach ($data as $key => $value) {

			$rowData = explode(',', $value->row);
			$table.='<tr>';
			$table.='<input type="hidden" name="row[]" value="'.$value->row.'">';
			$j=1;
				foreach ($rowData as $key => $val) {
					if($i!=1 && $j!=1){
						$ids = $i.'_'.$j;
						$table.='<td><input type="text" name="test'.$j.$i.'" value="'.$val.'" class="price_input" id="'.$ids.'" autocomplete="off" /></td>';
					}else{
						$table.='<td><input type="text" name="test'.$j.$i.'" value="'.$val.'" autocomplete="off" /></td>';
					}
					$j++;
				}
			$table.='</tr>';
			$i++;
		}
		
		$table.='</table>';

		echo $table;

	}





}
