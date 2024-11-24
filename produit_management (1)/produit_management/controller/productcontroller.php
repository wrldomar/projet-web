<?php
  include(__DIR__ . '/../config.php');
include(__DIR__ . '/../model/product.php');

class ProductController {
    // Function to add a new product
    public function addProduct($product) {
        $sql = "INSERT INTO products (id_farmer, id_categorie, name_product, product_price, quantite, product_image) 
                VALUES (:id_farmer, :id_categorie, :name_product, :product_price, :quantite, :product_image)";
        $db = config::getConnexion();
    
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id_farmer' => $product->getIdFarmer(),
                'id_categorie' => $product->getIdCategorie(),
                'name_product' => $product->getNameProduct(),
                'product_price' => $product->getProductPrice(),
                'quantite' => $product->getQuantite(),
                'product_image' => $product->getProductImage(),
            ]);
            return true; // Indicates success
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function listProductsByCategory($id_categorie = null) {
        $db = config::getConnexion();
        $sql = "SELECT * FROM products";
        if ($id_categorie !== null) {
            $sql .= " WHERE id_categorie = :id_categorie";
        }
    
        try {
            $query = $db->prepare($sql);
            if ($id_categorie !== null) {
                $query->execute(['id_categorie' => $id_categorie]);
            } else {
                $query->execute();
            }
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function getAllProducts()
    {
        // Create a connection to the database
        $pdo = Config::getConnexion();

        // Prepare and execute the query to fetch all products
        $query = "SELECT * FROM products";  // Modify table name based on your schema
        $stmt = $pdo->prepare($query);

        try {
            $stmt->execute();  // Execute the query
            $products = $stmt->fetchAll();  // Fetch all products as an associative array
            return $products;
        } catch (Exception $e) {
            // Handle any errors, such as database connection issues
            die('Error: ' . $e->getMessage());
        }
    }
    public function getProductImageById($id_product) {
        try {
            $db = config::getConnexion();
            $query = "SELECT product_image FROM products WHERE id_product = :id_product";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id_product', $id_product);
            $stmt->execute();
            $result = $stmt->fetch();
            return $result ? $result['product_image'] : null;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
    
    public function updateProduct($id_product, $id_farmer, $id_categorie, $name_product, $product_price, $quantite, $product_image) {
        try {
            // Check if a new image has been uploaded
            // Proceed to update the product in the database with the (new or old) image
            $db = config::getConnexion();
            $query = "UPDATE products SET 
                      id_farmer = :id_farmer, 
                      id_categorie = :id_categorie, 
                      name_product = :name_product, 
                      product_price = :product_price, 
                      quantite = :quantite, 
                      product_image = :product_image 
                      WHERE id_product = :id_product";
    
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id_product', $id_product);
            $stmt->bindParam(':id_farmer', $id_farmer);
            $stmt->bindParam(':id_categorie', $id_categorie);
            $stmt->bindParam(':name_product', $name_product);
            $stmt->bindParam(':product_price', $product_price);
            $stmt->bindParam(':quantite', $quantite);
            $stmt->bindParam(':product_image',$product_image);
    
            // Execute the statement
            $stmt->execute();
    
            return true;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    public function deleteProduct($id_product) {
        try {
            $db = config::getConnexion();
            $query = "DELETE FROM products WHERE id_product = :id_product";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id_product', $id_product);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    public function getProductById($id_product) {
        try {
            $db = config::getConnexion();
            $query = "SELECT * FROM products WHERE id_product = :id_product";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id_product', $id_product);
            $stmt->execute();
            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

}
?>
