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

    // Function to list products by category with search and pagination
    public function listProductsByCategory($id_categorie = null, $search_query = '', $limit = 10, $offset = 0) {
        $db = config::getConnexion();
        $sql = "SELECT * FROM products WHERE 1";
        
        // Filter by category
        if ($id_categorie !== null) {
            $sql .= " AND id_categorie = :id_categorie";
        }
        
        // Filter by product name
        if (!empty($search_query)) {
            $sql .= " AND name_product LIKE :search_query";
        }

        // Add LIMIT and OFFSET for pagination
        $sql .= " LIMIT :limit OFFSET :offset";
    
        try {
            $query = $db->prepare($sql);
            
            // Bind parameters
            if ($id_categorie !== null) {
                $query->bindValue(':id_categorie', $id_categorie, PDO::PARAM_INT);
            }
            if (!empty($search_query)) {
                $query->bindValue(':search_query', '%' . $search_query . '%', PDO::PARAM_STR);
            }
            $query->bindValue(':limit', $limit, PDO::PARAM_INT);
            $query->bindValue(':offset', $offset, PDO::PARAM_INT);
            
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Function to get all products with search and pagination
    public function getAllProducts($search_query = '', $limit = 6, $offset = 0) {
        $db = config::getConnexion();
        $sql = "SELECT * FROM products WHERE 1";
        
        // Filter by product name
        if (!empty($search_query)) {
            $sql .= " AND name_product LIKE :search_query";
        }

        // Add LIMIT and OFFSET for pagination
        $sql .= " LIMIT :limit OFFSET :offset";
    
        try {
            $query = $db->prepare($sql);
            
            // Bind parameters
            if (!empty($search_query)) {
                $query->bindValue(':search_query', '%' . $search_query . '%', PDO::PARAM_STR);
            }
            $query->bindValue(':limit', $limit, PDO::PARAM_INT);
            $query->bindValue(':offset', $offset, PDO::PARAM_INT);
            
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Function to count total products (for pagination)
    public function countProducts($search_query = '') {
        $db = config::getConnexion();
        $sql = "SELECT COUNT(*) FROM products WHERE 1";
        
        // Filter by product name
        if (!empty($search_query)) {
            $sql .= " AND name_product LIKE :search_query";
        }
    
        try {
            $query = $db->prepare($sql);
            
            // Bind parameter
            if (!empty($search_query)) {
                $query->bindValue(':search_query', '%' . $search_query . '%', PDO::PARAM_STR);
            }
            
            $query->execute();
            return $query->fetchColumn();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Function to get product image by product ID
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
    
    // Function to update a product
    public function updateProduct($id_product, $id_farmer, $id_categorie, $name_product, $product_price, $quantite, $product_image) {
        try {
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
            $stmt->bindParam(':product_image', $product_image);
    
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Function to delete a product
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


    //recherche 
        public function searchProductsByName($searchTerm) {
            $db = config::getConnexion();
            $sql = "SELECT * FROM products WHERE name_product LIKE :searchTerm";
    
            try {
                $query = $db->prepare($sql);
                $query->execute(['searchTerm' => '%' . $searchTerm . '%']);
                return $query->fetchAll(PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                die('Error: ' . $e->getMessage());
            }
        }
    
        public function BackSearchByName($searchTerm) {
            $db = config::getConnexion();
            $sql = "SELECT * FROM products WHERE name_product LIKE :searchTerm";
            
            try {
                $query = $db->prepare($sql);
                $query->execute(['searchTerm' => '%' . $searchTerm . '%']);
                $results = $query->fetchAll(PDO::FETCH_ASSOC);
                
                // Debugging: Check if the results are correct
                if (empty($results)) {
                    echo "No products found for the search term.";
                }
                
                return $results;
            } catch (Exception $e) {
                die('Error: ' . $e->getMessage());
            }
        }
        
        public function getProductById($id_product) {
            $db = config::getConnexion();
            $sql = "SELECT * FROM products WHERE id_product = :id_product";  // Query to fetch product by ID
            
            try {
                $query = $db->prepare($sql);
                $query->bindValue(':id_product', $id_product, PDO::PARAM_INT);  // Bind the product ID to the query
                $query->execute();
                
                // Fetch and return the product data
                $result = $query->fetch(PDO::FETCH_ASSOC);
                return $result ? $result : null;  // Return the product data or null if not found
            } catch (Exception $e) {
                die('Error: ' . $e->getMessage());
            }
        }


        
        
    
}

?>
