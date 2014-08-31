<?php
class CategoriesComponent extends Component {
	public static $categories = array (
			"8"	=> array(
						"name"	=>	"MOBA",
						"games"	=>	array()
					),
			"1"	=>	array(
						"name"	=>	"MMO",
						"games"	=>	array()
					),
			"5"	=>	array(
						"name"	=>	"RTS",
						"games"	=>	array()
					),
			"3"	=>	array(
						"name"	=>	"FPS",
						"games"	=>	array()
					),
			"9"	=> array(
						"name"	=>	"V-FIGHT",
						"games"	=>	array()
					),
			"0"	=>	array(
						"name"	=>	"OTHERS",
						"games"	=>	array()
					)
		);
		
    public function getGamesInCategories() {
		$categories = self::$categories;
		$games = $this->requestAction(array('controller'=>'games', 'action' => 'listgames'));
			foreach ($games as $game) :
				array_push($categories[$game['Game']['category']]['games'],$game);
			endforeach;
		return $categories;
    }
	 public function getCategoriesName() {
		$categories	=	array();
			foreach (self::$categories as $id => $array) :
				$categories[$id] = $array['name'];
			endforeach;
		return $categories;
    }
}
?>