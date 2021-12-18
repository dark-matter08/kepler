<?php

    // include '../includes/config.php';

   function pagination($query, $per_page, $page, $con, $orderBy, $dir){
		$url = '?';
		$query = "SELECT * FROM property WHERE status = '1' ORDER BY $orderBy $dir";
		$prepareQ = $con->prepare("SELECT * FROM property WHERE status = '1' ORDER BY $orderBy $dir");
		// $prepareQ->bindParam(":query", $quer);
		// $prepareQ->bindParam(":orderBy", $orderBy);
		// $prepareQ->bindParam(":dir", $dir);
		$prepareQ->execute();
		// $row = $prepareQ->fetch(PDO::FETCH_ASSOC);
		$total = $prepareQ->rowCount();
		// $total = $row['num'];
		$adjacents = "2";

		$page = ($page == 0 ? 1 : $page);
		$start = ($page - 1) * $per_page;

		$prev = $page - 1;
		$next = $page + 1;
		$lastpage = ceil($total/$per_page);
		$lpm1 = $lastpage - 1;

		$pagination = "";
		if($lastpage > 1)
		{
			$pagination .= "<ul class='pagination justify-content-end'>";
			$pagination .= "<li class='page-item'><a class='page-link'>Page $page of $lastpage</a></li>";
			if ($lastpage < 7 + ($adjacents * 2))
			{
				for ($counter = 1; $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class='page-item'><a class='page-link active'>$counter</a></li>";
					else
						$pagination.= "<li class='page-item'><a href='{$url}page=$counter' class='page-link'>$counter</a></li>";
				}
			}
			elseif($lastpage > 5 + ($adjacents * 2))
			{
				if($page < 1 + ($adjacents * 2))
				{
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
					{
						if ($counter == $page)
							$pagination.= "<li class='page-item'><a class='page-link  active'>$counter</a></li>";
						else
							$pagination.= "<li class='page-item'><a class='page-link ' href='{$url}page=$counter'>$counter</a></li>";
					}
					$pagination.= "<li class='dot'>...</li>";
					$pagination.= "<li class='page-item'><a class='page-link' href='{$url}page=$lpm1'>$lpm1</a></li>";
					$pagination.= "<li class='page-item'><a class='page-link' href='{$url}page=$lastpage'>$lastpage</a></li>";
				}
				elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
				{
					$pagination.= "<li class='page-item'><a class='page-link' href='{$url}page=1'>1</a></li>";
					$pagination.= "<li class='page-item'><a class='page-link' href='{$url}page=2'>2</a></li>";
					$pagination.= "<li class='dot'>...</li>";
					for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<li class='page-item'><a class='page-link active'>$counter</a></li>";
						else
							$pagination.= "<li class='page-item'><a class='page-link' href='{$url}page=$counter'>$counter</a></li>";
					}
					$pagination.= "<li class='dot'>..</li>";
					$pagination.= "<li class='page-item'><a class='page-link' href='{$url}page=$lpm1'>$lpm1</a></li>";
					$pagination.= "<li class='page-item'><a class='page-link' href='{$url}page=$lastpage'>$lastpage</a></li>";
				}
				else
				{
					$pagination.= "<li class='page-item'><a class='page-link' href='{$url}page=1'>1</a></li>";
					$pagination.= "<li class='page-item'><a class='page-link' href='{$url}page=2'>2</a></li>";
					$pagination.= "<li class='dot'>..</li>";
					for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<li class='page-item'><a class='page-link active'>$counter</a></li>";
						else
							$pagination.= "<li class='page-item'><a class='page-link' href='{$url}page=$counter'>$counter</a></li>";
					}
				}
			}

			if ($page < $counter - 1){
				$pagination.= "<li class='page-item'><a class='page-link' href='{$url}page=$next'>&rsaquo;</a></li>";
				$pagination.= "<li class='page-item'><a class='page-link' href='{$url}page=$lastpage'>&raquo;</a></li>";
			}else{
				$pagination.= "<li class='page-item'><a class='page-link active'>&rsaquo;</a></li>";
				$pagination.= "<li class='page-item'><a class='page-link active'>&raquo;</a></li>";
			}
			$pagination.= "</ul>\n";
		}


		return $pagination;
    }
?>
