<?php
/*
SELECT c.Name as `Category Name`, COUNT(r.categoryId) as `Total Items` FROM `category` c INNER JOIN Item_category_relations r ON c.id=r.categoryId
GROUP BY categoryId ORDER BY COUNT(r.categoryId) DESC
*/

/*
 SELECT C1.name, C1.id, C1.total, C2.parent FROM (SELECT c.Name as name, c.Id as id , COUNT(r.categoryId) as total FROM `category` c LEFT OUTER JOIN Item_category_relations r ON c.id=r.categoryId GROUP BY c.id) as C1 JOIN (SELECT c.Id as id, cr.ParentcategoryId parent FROM category c LEFT OUTER JOIN catetory_relations cr ON c.Id=cr.categoryId) as C2 ON C1.id = C2.id ORDER by C1.id
 */
include_once("vendor/autoload.php");

echo '<a href="/?page=nested">Nested category</a>';
echo '<a href="/" style="padding-left: 20px">Category Item Count</a>';

if (isset($_GET['page']))
    $data = (new \App\Category())->categoryCount();
else
    $data = (new \App\Category())->getAllCategories();
?>
