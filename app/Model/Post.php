<?php
App::uses('AppModel', 'Model');
App::uses('User', 'Model');
App::uses('Topic', 'Model');
App::uses('Forum', 'Model');

class Post extends AppModel {

	public $useTable = 'forum_posts';

	public $validate = array(
		'body' => array(
		'rule' => 'notEmpty'
		)
	);
	
	public function isOwnedBy($post, $user) {
		return false;
	}

	public function myFind($page, $topicId, $nbParPage=25) {
		$min = ($page-1)*$nbParPage;
		$db = $this->getDataSource();
		$sql = "SELECT * FROM forum_posts as Post WHERE Post.topic_id=".$topicId." ORDER BY Post.posted ASC LIMIT ".$min.", ".$nbParPage;
		$posts = $db->query($sql);
		foreach($posts as $k=>$v) {
			$posts[$k]['Post']['message'] = $this->parseMessage($posts[$k]['Post']['message']);
			$posts[$k]=$posts[$k]['Post'];
		}
		return $posts;
	}

	public function countPosts($topicId) {
		$db = $this->getDataSource();
		$sqlCount = "SELECT COUNT(*) FROM forum_posts WHERE topic_id=".$topicId;
		$r = $db->query($sqlCount);
		return $r;
	}

	public function parseMessage($text) {
		$pattern[] = '%\[right\](.*?)\[/right\]%ms';
		$pattern[] = '%\[left\](.*?)\[/left\]%ms';
		$pattern[] = '%\[center\](.*?)\[/center\]%ms';
		$pattern[] = '%\[size=(\d+)\](.*?)\[/size\]%ms';
		$pattern[] = '%\[b\](.*?)\[/b\]%ms';
		$pattern[] = '%\[i\](.*?)\[/i\]%ms';
		$pattern[] = '%\[u\](.*?)\[/u\]%ms';
		$pattern[] = '%\[s\](.*?)\[/s\]%ms';
		$pattern[] = '%\[del\](.*?)\[/del\]%ms';
		$pattern[] = '%\[ins\](.*?)\[/ins\]%ms';
		$pattern[] = '%\[em\](.*?)\[/em\]%ms';
		$pattern[] = '%\[colou?r=([a-zA-Z]{3,20}|\#[0-9a-fA-F]{6}|\#[0-9a-fA-F]{3})](.*?)\[/colou?r\]%ms';
		$pattern[] = '%\[h\](.*?)\[/h\]%ms';
		$pattern[] = '%\[img\](.*?)\[/img\]%ms';
		$pattern[] = '%\[quote=(.*?)\](.*?)\[/quote\]%ms';

		$replace[] = '<div style="text-align:right;">$1</div>';
		$replace[] = '<div style="text-align:left;">$1</div>';
		$replace[] = '<div style="text-align:center;">$1</div>';
		$replace[] = '<div style="font-size:$1%;">$2</div>';
		$replace[] = '<strong>$1</strong>';
		$replace[] = '<em>$1</em>';
		$replace[] = '<span class="bbu">$1</span>';
		$replace[] = '<span class="bbs">$1</span>';
		$replace[] = '<del>$1</del>';
		$replace[] = '<ins>$1</ins>';
		$replace[] = '<em>$1</em>';
		$replace[] = '<span style="color: $1">$2</span>';
		$replace[] = '</p><h5>$1</h5><p>';
		$replace[] = '<img src="$1">';
		$replace[] = '<p><bold class="text-success">$1 wrote: </bold></p><p class="well">$2</p>';

		// This thing takes a while! :)
		$text = preg_replace($pattern, $replace, $text);
		return $text;
	}

	public function afterFind($results, $primary=false) {
		if (!$primary) {
			//model lié
			$text = $results[0]['Post']['message'];
			$text = $this->parseMessage($text);
			$results[0]['Post']['message'] = $text;
		}
		return $results;
	}

	public function isAuthReply($topicId, $user) {
		$classTopic = new Topic();
		$classUser = new User();
		$topic = $classTopic->find('all', array('conditions'=>array('id'=>$topicId)));
		$topic = $topic[0]['Topic'];
		$groupId = $user['group_id'];
		$forum_indispo = $classUser->getForumIndispo($groupId);
		if ($forum_indispo == null) return true;
		$forumId = $topic['forum_id'];
		$classForum = new Forum();
		$f = $classForum->find('all', array('conditions'=>array('id'=>$forumId)));
		$f = $f[0]['Forum'];
		if(in_array($f['id'], $forum_indispo)) {
			return false;
		} else {
			return true;
		}
		return false;
	}
}
?>