<?php


namespace App;


class Category extends DB
{
    private $categories = [];

    public function getAllCategories()
    {
        $categories = $this->itemList('SELECT c.Name as `category`, COUNT(r.categoryId) as `total` FROM `category` c INNER JOIN Item_category_relations r ON c.id=r.categoryId
GROUP BY categoryId ORDER BY COUNT(r.categoryId) DESC');
        if (is_array($categories)) {
            echo '<table><tr><th>Category Name</th><th>Total Items</th></tr>';
            foreach ($categories as $category) {
                echo "<tr><td>{$category['category']}</td><td>{$category['total']}</td></tr>";
            }
            echo '</table>';
        }
    }

    public function categoryCount()
    {
        echo '<pre>';
        $this->categories = $this->itemList('SELECT C1.name, C1.id, C1.total, C2.parent FROM (SELECT c.Name as name, c.Id as id , COUNT(r.categoryId) as total FROM `category` c LEFT OUTER JOIN Item_category_relations r ON c.id=r.categoryId GROUP BY c.id) as C1 JOIN (SELECT c.Id as id, cr.ParentcategoryId parent FROM category c LEFT OUTER JOIN catetory_relations cr ON c.Id=cr.categoryId) as C2 ON C1.id = C2.id ORDER by C1.id');
        $result = $this->getAllChild($this->categories);
        $this->printTree($result);

    }


    function printTree($tree)
    {
        if (!is_null($tree) && count($tree) > 0) {
            echo '<ul>';
            foreach ($tree as $node) {
                echo '<li>' . $node['name'] . ' (' . $node['total'] . ')';
                $this->printTree($node['children']);
                echo '</li>';
            }
            echo '</ul>';
        }
    }

    function getAllChild(array $categories, $parentId = null, $deep = 1)
    {
        $result = array();
        foreach ($categories as $category) {
            if ($category['parent'] == $parentId) {
                $category['children'] = $this->getAllChild($categories, $category['id']);
                $result[$category['id']] = $category;

            }
        }
        return $result;
    }

}