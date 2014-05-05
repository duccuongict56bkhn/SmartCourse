<?php 
$queryStatus = array(); 
try { 
	$conn = new PDO(DB_MAIN_SITE_DSN, 
					DB_MAIN_SITE_USERNAME, 
					DB_MAIN_SITE_PASSWORD, 
					array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
	$sql = "INSERT INTO tbl_article(article_title, article_publicationDate, article_description, 
									article_content, article_avatar, article_thumb, article_titleX, 
									article_titleDisplay, article_visitCount, article_link, 
									article_tagDescription, article_tagKeywords, 
									article_status, catarticle_id , user_username, article_tags) 
			VALUES ('" . $article->getArticle_title() . "'," 
				   . $article->getArticle_publicationDate() . ", '" 
				   . $article->getArticle_description() . 
				   "', ? , '" . $article->getArticle_avatar() . 
				   "', '', '" . $article->getArticle_titleX() . 
				   "', '" . $article->getArticle_titleDisplay() . 
				   "', 0, '" . $article->getArticle_link() . 
				   "', '" . $article->getArticle_tagDescription() . 
				   "', '" . $article->getArticle_tagKeywords() . 
				   "', 1, " . $article->getCatarticle_id() . 
				   " , '" . $article->getUser_username() . 
				   "', '" . $article->getArticle_tags() . "')  "; 
	$st = $conn->prepare($sql); 
	$st->bindParam(1, $article->getArticle_content()); $st->execute(); $conn = null; 
} catch (PDOException $e) { 
	$queryStatus["status"] = false; 
	$queryStatus["result"] = $e->getMessage(); 
	return $queryStatus; 
}
$queryStatus["status"] = true; 
$queryStatus["result"] = null; 
return $queryStatus;
	?>