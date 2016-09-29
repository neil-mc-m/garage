<?php

namespace CMS;

use Doctrine\Dbal\Connection;
use Doctrine\DBAL\Driver\PDOException;
use \PDO;

/**
 * A data access class.
 *
 * All data access for tables.
 */
class DbRepository {
	/**
	 * Doctrine Connection object
	 *
	 * @var Connection instance
	 */
	private $conn;

	public function __construct(Connection $conn) {
		$this->conn = $conn;
	}

	public function getAllPages() {
		try {
			$stmt = $this->conn->prepare('SELECT * FROM page');
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_CLASS, __NAMESPACE__ . '\\Page');

			return $result;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function getSinglePage($pageName) {
		try {
			$stmt = $this->conn->prepare('SELECT * FROM page WHERE pageName=:pageName');
			$stmt->bindParam(':pageName', $pageName);
			$stmt->setFetchMode(PDO::FETCH_CLASS, __NAMESPACE__ . '\\Page');
			$stmt->execute();
			if ($result = $stmt->fetch()) {
				return $result;
			} else {
				return;
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function getPageName($pageRoute) {
		try {
			$stmt = $this->conn->prepare('SELECT pageName FROM page WHERE pageRoute=:pageRoute');
			$stmt->bindParam(':pageRoute', $pageRoute);
			$stmt->execute();
			$result = $stmt->fetchColumn();

			return $result;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/**
	 * @param id. The id of the car record required.
	 *
	 * @return a bool for success/failure
	 */
	public function getOneCar($id) {
		try {
			$stmt = $this->conn->prepare('SELECT * FROM car WHERE id =:id');
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$stmt->execute();
			if ($result = $stmt->fetch()) {
				return $result;
			} else {
				return;
			}
		} catch (PDOException $e) {
			echo $e->getMessage;
		}
	}

    /**
     * update a car record in the database.
     *
     * @param array $carDataArray
     * @param $id
     * @return int|string
     */
    public function updateCar(array $carDataArray, $id)
    {
        try{
            $count = $this->conn->update('car', $carDataArray, array('id' => $id));
            return $count;
        } catch(PDOException $e){
            return $e->getMessage();
        }
    }
	/**
	 * gets a pages content.
	 *
	 * @param string $page a page
	 *
	 * @return twig template    template for the page.
	 */
//	public function getContent($pageName) {
//		try {
//			$stmt = $this->conn->prepare('SELECT * FROM content WHERE pageName =:pageName');
//			$stmt->bindParam(':pageName', $pageName, PDO::PARAM_STR, 5);
//			$stmt->execute();
//			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//
//			return $result;
//		} catch (PDOException $e) {
//			echo $e->getMessage();
//		}
//	}

    /**
     * fetch all car records from the database
     *
     * @return array
     */
    public function getCars()
    {
        $stmt = $this->conn->prepare('SELECT * FROM car');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);

        return $result;
    }
	public function getAllPagesContent() {
		try {
			$stmt = $this->conn->prepare('SELECT * FROM car');
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_OBJ);

			return $result;
		} catch (\PDOException $e) {
			return $e->getMessage();
		}
	}

	/**
	 * Creates a new web page from the parameters given.
	 *
	 * @param string $pageName     the pagename
	 * @param string $pagePath     the page path/route
	 * @param string $pageTemplate the page template
	 *
	 * @return twig template        the template for the page.
	 */
	public function createPage($pageName, $pageRoute, $pageTemplate) {

			$stmtpage = $this->conn->prepare('INSERT IGNORE INTO page(pageId, pageName, pageRoute, pageTemplate, created) VALUES (DEFAULT, :pageName, :pageRoute, :pageTemplate, curdate())');
			$stmttemplate = $this->conn->prepare('INSERT IGNORE INTO templates(templateid, name, source, last_modified) VALUES (DEFAULT, :name, :source, curdate())');
			# a pdo transaction to execute two queries at the same time.
			# both have to execute without an error for each to work.
			# i.e if theres an error in the second statement, the first statement
			# wont execute either so its both or nothing.
			$this->conn->beginTransaction();
        try{
			$pageName = strtolower($pageName);
			$stmtpage->bindParam(':pageName', $pageName);
			$stmtpage->bindParam(':pageRoute', $pageRoute);
			$stmtpage->bindParam(':pageTemplate', $pageTemplate);
			$count = $stmtpage->execute();

			$pageTemplate = $pageTemplate . '.html.twig';
			$templatecontent = "{% extends 'base.html.twig' %}";
			$stmttemplate->bindParam(':name', $pageTemplate);
			$stmttemplate->bindParam(':source', $templatecontent);
			$count = $stmttemplate->execute();

			$this->conn->commit();
            return $count;

		} catch (PDOException $e) {
		    $this->conn->rollBack();
			echo $e->getMessage();
		}
	}

	/**
	 * Remove a page.
	 *
	 * Also removes a template from the database with the same page name.
	 *
	 * @param string $pageName the page to remove
	 *
	 * @return twig template
	 */
	public function deletePage($pageName, $pageTemplate) {

			$stmtpage = $this->conn->prepare('DELETE FROM page WHERE pageName =:pageName');
			$stmttemplate = $this->conn->prepare('DELETE FROM templates WHERE name =:pageTemplate');
			$stmtcontent = $this->conn->prepare('DELETE FROM content WHERE pageName=:pageName');
			# begins a transaction for a multiple query
			$this->conn->beginTransaction();
        try {
			$stmtpage->bindParam(':pageName', $pageName);
			$count = $stmtpage->execute();

			$template = $pageTemplate . '.html.twig';
			$stmttemplate->bindParam(':pageTemplate', $template);
			$stmttemplate->execute();

			$stmtcontent->bindParam(':pageName', $pageName);
			$count = $stmtcontent->execute();
            $this->conn->commit();

            return $count;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

//	public function createContent($pageName, $contentType, $contentItemTitle, $contentItem) {
//		try {
//			$pdo = new DbManager();
//			$conn = $pdo->getPdoInstance();
//			$result = '';
//			$stmt = $conn->prepare('INSERT INTO content(contentId, pageName, contentType, contentItemTitle, contentItem, created) VALUES (DEFAULT, :pagename, :contenttype, :contentitemtitle, :contentitem, curdate())');
//			$stmt->bindParam(':pagename', $pageName);
//			$stmt->bindParam(':contenttype', $contentType);
//			$stmt->bindParam(':contentitemtitle', $contentItemTitle);
//			$stmt->bindParam(':contentitem', $contentItem);
//			if (!$stmt->execute()) {
//				$result .= 'Heuston we have a problem!';
//			}
//
//			return $result .= 'Nice. Some new content created';
//		} catch (PDOException $e) {
//			echo $e->getMessage();
//		}
//	}

    /**
     * @param array $arr array of data from the create new car form.
     * @return int
     */
    public function createNewCar(array $arr)
    {
        try{
            $count = $this->conn->insert('car', $arr);
            return $count;
        } catch (PDOException $e) {
            return $e->getMessage();
        }


    }


    /** delete a car record form the database
     *
     * @param $id
     * @return string
     */
    public function deleteCar($id) {
		try {

			$stmt = $this->conn->prepare('DELETE FROM car WHERE id=:id');
			$stmt->bindParam(':id', $id);
			$count = $stmt->execute();
            return $count;

		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

//	public function editContent($contentId, $pageName, $contentType, $contentItemTitle, $contentItem) {
//		try {
//			$result = '';
//			$stmt = $this->conn->prepare('UPDATE content SET pageName=:pageName, contentType=:contentType, contentItemTitle=:contentItemTitle, contentItem=:contentItem, modified=curdate() WHERE contentId=:contentId');
//			$stmt->bindParam(':pageName', $pageName);
//			$stmt->bindParam(':contentType', $contentType);
//			$stmt->bindParam(':contentItemTitle', $contentItemTitle);
//			$stmt->bindParam(':contentItem', $contentItem);
//			$stmt->bindParam(':contentId', $contentId);
//			if (!$stmt->execute()) {
//				return $result .= 'Heuston, We have a problem!';
//			}
//
//			return $result .= 'Successfully updated ' . $stmt->rowCount() . ' Items';
//		} catch (PDOException $e) {
//			echo $e->getMessage();
//		}
//	}

	public function viewImages() {
		try {
			$stmt = $this->conn->prepare('SELECT * FROM image');
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_CLASS, __NAMESPACE__ . '\\Image');

			return $result;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

    public function getOneCarImage($id)
    {
        try {
            $stmt = $this->conn->prepare('SELECT imagePath FROM image WHERE id=:id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_COLUMN);
            return $result;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

	public function addImage($carid, $imageid) {
		try {
//            $count = $this->conn->executeUpdate('UPDATE image SET carid =:carid WHERE id =:imageid', array($carid, $imageid));
            $count = $this->conn->update('image', array('carid' => $carid), array('id' => $imageid));

			return $count;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

    /**Delete an image path from the db with the id provided.
     *
     * @param $id
     * @return int|string
     */
    public function deleteImage($id)
    {
        try {
            $count = $this->conn->delete('image', array('id' => $id));
            return $count;
        } catch (PDOException $e) {
            $count = $e->getMessage();
            return $count;
        }
    }

    /**Upload an image path to the db for storage.
     *
     * @param $image
     * @return string
     */
    public function uploadImage($image) {
		try {
			$result = '';
			$stmt = $this->conn->prepare('INSERT IGNORE INTO image(id, carid, imagePath) VALUES(DEFAULT, DEFAULT, :imagePath)');
			$stmt->bindParam(':imagePath', $image);
			if (!$stmt->execute()) {
				$result .= 'Heuston, we have a problem!';
			} else {
				$result .= 'Great! Successfully uploaded ' . $stmt->rowCount() . ' Image';
			}

			return $result;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

    /** Frontend function to retrieve all images associated with a car id
     *  used on the single car page.
     *
     * @param $id
     * @return mixed|string
     */
    public function getCarImages($id)
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM image WHERE carid=:id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            $result = $e->getMessage();
            return $result;
        }
    }
    public function makeLeadImage($carid, $imageid)
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM image WHERE id = :imageid');
            $stmt->bindParam('imageid', $imageid);
            $stmt->execute();
            while ($row = $stmt->fetch()){
                $image = $row['imagePath'];
            }
//            ->update('user', array('username' => 'jwage'), array('id' => 1));
            $count = $this->conn->update('car', array('image' => $image), array('id' => $carid));
            return $count;
        } catch (PDOException $e) {
            $result = $e->getMessage();
            return $result;
        }
    }

	public function search($q) {
		try {

			$stmt = $this->conn->prepare('SELECT id,make,model FROM car WHERE make LIKE :q');
			$q = '%' . $q . '%';
			$stmt->bindParam(':q', $q);
			$stmt->execute();

			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);



			return $result;
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

}
