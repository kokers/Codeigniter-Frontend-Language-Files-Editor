<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model for CodeIgniter frontend language files editor.
 *
 * Tested for CodeIgniter 2.x
 * @author		Eliza Witkowska (http://codebusters.pl/en/)
 * @version		2.1
 * @license		MIT License
 * @link	http://blog.codebusters.pl/en/entry/codeigniter-frontend-language-files-editor/
 * @link https://github.com/kokers/Codeigniter-Frontend-Language-Files-Editor
 */

class Model_language extends CI_Model {

	/**
	 * Get list of languages based on /application_folder/languge/
	 * and number of php files in it
	 *
	 * @return	array
	 */
	function get_languages(){
		$dir = APPPATH."language/";
		$dh  = opendir($dir);
		$i=0;
		while (false !== ($filename = readdir($dh))) {
			if($filename!=='.' && $filename!=='..' && is_dir($dir.$filename)){
				$files[$i]['dir'] = $filename;
				$files[$i]['count']=$this->get_count_lfiles($filename);
				$i++;
			}
		}
		return (!empty($files))?$files:FALSE;
	}

	/**
	 * Get list of files from language directory
	 *
	 * @param string
	 * @return	array
	 */
	function get_list_lfiles($dir){
		if(!is_dir(APPPATH."language/$dir/")){ return FALSE; }
		$dir = APPPATH."language/$dir/";
		$dh  = opendir($dir);
		while (false !== ($filename = readdir($dh))) {
			if($filename!=='.' && $filename!=='..' && !is_dir($dir.$filename) && pathinfo($filename, PATHINFO_EXTENSION)=='php' && substr($filename,0,7)!='backup_'){
				$files[] = $filename;
			}
		}
		return (!empty($files))?$files:FALSE;
	}

	/**
	 * Get number of files from language directory
	 *
	 * @param string
	 * @return	int
	 */
	function get_count_lfiles($dir){
		if(!is_dir(APPPATH."language/$dir/")){ return FALSE; }
		$dir = APPPATH."language/$dir/";
		$dh  = opendir($dir);
		$i=0;
		while (false !== ($filename = readdir($dh))) {
			if($filename!=='.' && $filename!=='..' && !is_dir($dir.$filename) && pathinfo($filename, PATHINFO_EXTENSION)=='php' && substr($filename,0,7)!='backup_'){
				$i++;
			}
		}
		return (int)$i;
	}

	/**
	 * Get list of languages where file exist
	 *
	 * @param string
	 * @return	array
	 */
	function file_in_language($file){
		$lang = $this->get_languages();
		if($lang!==FALSE){
			foreach($lang as $l){
				$names = get_filenames(APPPATH."language/{$l['dir']}/");
				if(in_array($file,$names)){
					$in_lang[]=$l['dir'];
				}
			}
			return $in_lang;
		}
		return FALSE;
	}

	/**
	 * Get list of keys for file from database
	 *
	 * @param string
	 * @return	array
	 */
	function get_keys_from_db($file){
      $this->db->select('key as `keys`');
      $r = $this->db->get_where('language_keys', array('filename' => $file));
		if($r->num_rows()){
         $result=$r->result();
			foreach($result as $row){
            $tab[]=$row->keys;
			}
		}
		return (!empty($row)) ? $tab : FALSE;
   }

	/**
	 * Get list of keys for file from database
	 *
	 * @param string
	 * @return	array
	 */
	function get_comments_from_db($file){
      $this->db->select('key as `keys`,comment');
      $r = $this->db->get_where('language_keys', array('filename' => $file));
		if($r->num_rows()){
         $result=$r->result();
			foreach($result as $row){
            $tab[$row->keys]=$row->comment;
			}
		}
		return (!empty($row)) ? $tab : FALSE;
	}

	/**
	 * Update all keys in database, by removing previous and adding new.
	 *
	 * @param array
	 * @param string
	 * @return	bool
	 */
	function update_all_keys($keys,$file){
		$this->delete_all_keys($file);
		return $this->add_keys($keys,$file);
	}

	/**
	 * Add keys to database
	 *
	 * @param array
	 * @param string
	 * @return	bool
	 */
	function add_keys($keys,$file){
      if(!is_array($keys)){
         return FALSE;
      }
      foreach ($keys as $k){
         $data[] = array(
            'key'=>$k,
            'filename'=>$file
         );
      }
      $this->db->insert_batch('language_keys',$data);
      return ($this->db->affected_rows()) ? TRUE : FALSE;
	}


	/**
	 * Delete keys from database if file does not exists in any language
	 *
	 * @param string
	 * @return	bool
	 */
	function delete_keys($file){
		$lang = $this->get_languages();
		if($lang!==FALSE){
			foreach($lang as $l){
				$names = get_filenames(APPPATH."language/{$l['dir']}/");
				if(in_array($file,$names)){
					return FALSE;
				}
			}
			if($this->delete_all_keys($file)){
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}

	/**
	 * Delete keys from database
	 *
	 * @param string
	 * @return	bool
	 */
   function delete_all_keys($file){
      $this->db->delete('language_keys',array('filename'=>$file));
      return ($this->db->affected_rows()) ? TRUE : FALSE;
	}

   function delete_one_key($key,$file){
      $this->db->delete('language_keys',array('filename'=>$file,'key'=>$key));
      return ($this->db->affected_rows()) ? TRUE : FALSE;
   }

   function add_comments($com,$file){
      if(!is_array($com)){
         return FALSE;
      }
      $this->db->trans_start();
      foreach ($com as $k=>$c){
         $this->db->where('key', $k);
         $this->db->where('filename', $file);
         $this->db->update('language_keys',array('comment'=>$c));
      }
      $this->db->trans_complete();
		return ($this->db->trans_status()) ? TRUE : FALSE;
   }

}
/* End of file model_language.php */
