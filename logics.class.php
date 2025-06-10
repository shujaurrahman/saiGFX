<?php
require_once('./dbcredentials.class.php');


class logics extends dbcredentials{

        //Submitted Tasks Retieval
        public function SubmittedTasks(){
            $res = array();
            $res['status'] = 0;
            $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
            $query = $con->prepare(
                'SELECT tasks.task,tasks.url,tasks.doubts,tasks.created_at ,users.stud_id,users.name,users.email,users.domain
                FROM tasks 
                JOIN users ON users.id = tasks.user_id
                WHERE tasks.status=1
                ORDER BY tasks.id DESC'
            );
            if($query->execute()){
                $query->bind_result($task, $url, $doubts, $created_at,$stud_id,$name,$email,$domain);
                $i=0;
                while($query->fetch()){
                    $res['status']=1;
                    $res['task'][$i] = $task;
                    $res['url'][$i] = $url;
                    $res['doubts'][$i] = $doubts;
                    $res['created_at'][$i] = $created_at;
                    $res['stud_id'][$i] = $stud_id;
                    $res['name'][$i] = $name;
                    $res['email'][$i] = $email;
                    $res['domain'][$i] = $domain;
                    $i++;
                }
                $res['count']=$i;
            }else{
                $err = 'Statement not Executed';
            }
            return $res;
        }


    public function getUsers(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT id, name, email, mobile, role, profile_img, status, created_at 
                               FROM admin 
                               WHERE role != "super-admin" 
                               ORDER BY id DESC');
        if($query->execute()){
            $result = $query->get_result();
            $i = 0;
            while ($row = $result->fetch_assoc()) {
                $res['status'] = 1;
                $res['id'][$i] = $row['id'];
                $res['name'][$i] = $row['name'];
                $res['email'][$i] = $row['email'];
                $res['mobile'][$i] = $row['mobile'];
                $res['role'][$i] = $row['role'];
                $res['profile_img'][$i] = $row['profile_img'];
                $res['statusval'][$i] = $row['status'];  // Changed from status to statusval
                $res['created_at'][$i] = $row['created_at'];
                $i++;
            }
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        $query->close();
        $con->close();
        return $res;
    }
    public function updateUserRole($user_id, $new_role) {
        $res = array();
        $res['status'] = 0;
    
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        try {
            $query = $con->prepare("UPDATE admin SET role = ? WHERE id = ?");
            $query->bind_param('si', $new_role, $user_id);
            
            if ($query->execute()) {
                $res['status'] = 1;
                $res['message'] = 'Role updated successfully';
            }
        } catch (Exception $e) {
            $res['message'] = $e->getMessage();
        }
    
        $query->close();
        $con->close();
        return $res;
    }

    public function getUsersProfile(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare(
            "SELECT users.id, users.stud_id, users.name, users.email, users.password, 
                    users.domain, users.status, users.created_at, users.updated_at, 
                    profiles.mobile, profiles.college, profiles.dept, profiles.yop, profiles.address, profiles.profile 
             FROM users 
             JOIN profiles ON users.id = profiles.user_id 
             WHERE users.status = 1 
             ORDER BY users.created_at DESC"
        );
        if($query->execute()){
            $query->bind_result($id,$stud_id,$name,$email,$password,$domain,$status,$created_at,$updated_at,$mobile,$college,$dept,$yop,$address,$profile);
            $i=0;
            while($query->fetch()){
                $res['status'] = 1;
                $res['id'][$i] = $id;
                $res['stud_id'][$i] = $stud_id;
                $res['name'][$i] = $name;
                $res['email'][$i] = $email;
                $res['password'][$i] = $password;
                $res['status'][$i] = $status;
                $res['updated_at'][$i] = $updated_at;
                $res['domain'][$i] = $domain;
                $res['created_at'][$i] = $created_at;
                $res['mobile'][$i] = $mobile;
                $res['college'][$i] = $college;
                $res['dept'][$i] = $dept;
                $res['yop'][$i] = $yop;
                $res['address'][$i] = $address;
                $res['profile'][$i] = $profile;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function getInactiveUsersProfile(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare(
            "SELECT users.id, users.stud_id, users.name, users.email, users.password, 
                    users.domain, users.status, users.created_at, users.updated_at, 
                    profiles.mobile, profiles.college, profiles.dept, profiles.yop, profiles.address, profiles.profile 
             FROM users 
             JOIN profiles ON users.id = profiles.user_id 
             WHERE users.status = 0
             ORDER BY users.created_at DESC"
        );
        if($query->execute()){
            $query->bind_result($id,$stud_id,$name,$email,$password,$domain,$status,$created_at,$updated_at,$mobile,$college,$dept,$yop,$address,$profile);
            $i=0;
            while($query->fetch()){
                $res['status'] = 1;
                $res['id'][$i] = $id;
                $res['stud_id'][$i] = $stud_id;
                $res['name'][$i] = $name;
                $res['email'][$i] = $email;
                $res['password'][$i] = $password;
                $res['status'][$i] = $status;
                $res['updated_at'][$i] = $updated_at;
                $res['domain'][$i] = $domain;
                $res['created_at'][$i] = $created_at;
                $res['mobile'][$i] = $mobile;
                $res['college'][$i] = $college;
                $res['dept'][$i] = $dept;
                $res['yop'][$i] = $yop;
                $res['address'][$i] = $address;
                $res['profile'][$i] = $profile;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function updateUserProfileById( $stud_id,$name, $email, $password, $domain, $mobile,$college, $dept, $yop, $address, $profile, $id) {
        $res = array();
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
        // Prepare the update query
        $query = $con->prepare(
            "UPDATE users 
             JOIN profiles ON users.id = profiles.user_id 
             SET users.stud_id = ?,users.name = ?, users.email = ?, users.password = ?, 
                 users.domain = ?, profiles.mobile = ?, profiles.college = ?, 
                 profiles.dept = ?, profiles.yop = ?, profiles.address = ?, profiles.profile = ?
             WHERE users.id = ?"
        );
    
        // Bind the new data and the ID to the query
        $query->bind_param(
            'sssssssssssi', 
            $stud_id,$name, $email, $password, $domain, 
            $mobile, $college, $dept, $yop, 
            $address, $profile, $id
        );
    
        // Execute the query and check the result
        if($query->execute()){
            $res['status'] = 1;
            $res['message'] = 'Profile updated successfully';
        }else{
            $res['status'] = 0;
            $res['message'] = 'Failed to update profile';
        }
    
        // Close the statement and connection
        $query->close();
        $con->close();
    
        return $res;
    }
    


    public function getRegistrations(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT sno,name,mobile,email,college_name,college_location,dept,yop,created_at FROM registrations WHERE status=1 ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($sno,$name,$mobile,$email,$college_name,$college_location,$dept,$yop,$created_at);
            $i=0;
            while($query->fetch()){
                $res['status'] = 1;
                $res['sno'][$i] = $sno;
                $res['name'][$i] = $name;
                $res['mobile'][$i] = $mobile;
                $res['college_name'][$i] = $college_name;
                $res['college_location'][$i] = $college_location;
                $res['dept'][$i] = $dept;
                $res['email'][$i] = $email;
                $res['yop'][$i] = $yop;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }


    public function getInactiveRegistrations(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT sno,name,mobile,email,college_name,college_location,dept,yop,created_at FROM registrations WHERE status=0 ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($sno,$name,$mobile,$email,$college_name,$college_location,$dept,$yop,$created_at);
            $i=0;
            while($query->fetch()){
                $res['status'] = 1;
                $res['sno'][$i] = $sno;
                $res['name'][$i] = $name;
                $res['mobile'][$i] = $mobile;
                $res['college_name'][$i] = $college_name;
                $res['college_location'][$i] = $college_location;
                $res['dept'][$i] = $dept;
                $res['email'][$i] = $email;
                $res['yop'][$i] = $yop;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }



    public function getCareers(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT name,mobile,email,post,experience,resume,created_at FROM careers ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($name,$mobile,$email,$post,$experience,$resume,$created_at);
            $i=0;
            while($query->fetch()){
                $res['status'] = 1;
                $res['name'][$i] = $name;
                $res['mobile'][$i] = $mobile;
                $res['email'][$i] = $email;
                $res['post'][$i] = $post;
                $res['experience'][$i] = $experience;
                $res['resume'][$i] = $resume;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }



            public function getBlogs() {
                $res = array();
                $res['status'] = 0;
                $res['id'] = array();
                $res['username'] = array();
                $res['blog_heading'] = array();
                $res['blog_desc'] = array();
                $res['meta_title'] = array();
                $res['meta_keywords'] = array();
                $res['meta_description'] = array();
                $res['description'] = array();
                $res['featured_image'] = array();
                $res['slug_url'] = array();
                $res['status'] = array();
                $res['created_at'] = array();
                $res['count'] = 0;
                
                $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
                
                if ($con->connect_error) {
                    return $res;
                }
                
                $query = $con->prepare('SELECT id, username, blog_heading, blog_desc, meta_title, meta_keywords, meta_description, description, featured_image, slug_url, status, created_at FROM blogs ORDER BY id DESC');
                
                if (!$query) {
                    return $res;
                }
                
                if ($query->execute()) {
                    $query->store_result();
                    $query->bind_result($id, $username, $blog_heading, $blog_desc, $meta_title, $meta_keywords, $meta_description, $description, $featured_image, $slug_url, $status, $created_at);
                    $i = 0;
                    
                    while ($query->fetch()) {
                        $res['id'][$i] = $id;
                        $res['username'][$i] = $username;
                        $res['blog_heading'][$i] = $blog_heading;
                        $res['blog_desc'][$i] = $blog_desc;
                        $res['meta_title'][$i] = $meta_title;
                        $res['meta_keywords'][$i] = $meta_keywords;
                        $res['meta_description'][$i] = $meta_description;
                        $res['description'][$i] = $description;
                        $res['featured_image'][$i] = $featured_image;
                        $res['slug_url'][$i] = $slug_url;
                        $res['status_value'][$i] = $status; // Changed name to avoid conflict
                        $res['created_at'][$i] = $created_at;
                        $i++;
                    }
                    
                    $res['count'] = $i;
                    $res['status'] = 1; // Set status back to 1 when successful
                }
                
                $query->close();
                $con->close();
                return $res;
            }

            function getCurrentBlogWithNavigation($slug) {
                $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
                
                $res = [
                    'current' => null,
                    'prev' => null,
                    'next' => null
                ];
            
                if ($con->connect_error) return $res;
            
                // Get the current blog
                $stmt = $con->prepare("SELECT * FROM blogs WHERE slug_url = ? LIMIT 1");
                $stmt->bind_param("s", $slug);
                $stmt->execute();
                $result = $stmt->get_result();
            
                if ($result->num_rows == 1) {
                    $res['current'] = $result->fetch_assoc();
                    $currentId = $res['current']['id'];
            
                    // Get previous blog
                    $prevStmt = $con->prepare("SELECT id, blog_heading, slug_url FROM blogs WHERE id < ? ORDER BY id DESC LIMIT 1");
                    $prevStmt->bind_param("i", $currentId);
                    $prevStmt->execute();
                    $prevRes = $prevStmt->get_result();
                    if ($prevRes->num_rows == 1) {
                        $res['prev'] = $prevRes->fetch_assoc();
                    }
            
                    // Get next blog
                    $nextStmt = $con->prepare("SELECT id, blog_heading, slug_url FROM blogs WHERE id > ? ORDER BY id ASC LIMIT 1");
                    $nextStmt->bind_param("i", $currentId);
                    $nextStmt->execute();
                    $nextRes = $nextStmt->get_result();
                    if ($nextRes->num_rows == 1) {
                        $res['next'] = $nextRes->fetch_assoc();
                    }
                }
            
                $con->close();
                return $res;
            }
            
  

    public function getCategoryById($id){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT id,name,image,description,status,created_at FROM categories ORDER BY id DESC');
        if($query->execute()){
            $query->bind_result($id,$name, $image, $description, $status, $created_at);
            $i=0;
            while($query->fetch()){
                $res['status']=1;
                $res['id'][$i] = $id;
                $res['name'][$i] = $name;
                $res['image'][$i] = $image;
                $res['description'][$i] = $description;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function getContacts(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT name,email,mobile,query,created_at FROM contact ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($name, $email, $mobile, $message, $created_at);
            $i=0;
            while($query->fetch()){
                $res['status']=1;
                $res['name'][$i] = $name;
                $res['email'][$i] = $email;
                $res['mobile'][$i] = $mobile;
                $res['message'][$i] = $message;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function getQuotes(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT name,email,mobile,looking_for,when_to_start,created_at FROM quote ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($name, $email, $mobile, $looking_for,$when_to_start, $created_at);
            $i=0;
            while($query->fetch()){
                $res['status']=1;
                $res['name'][$i] = $name;
                $res['email'][$i] = $email;
                $res['mobile'][$i] = $mobile;
                $res['looking_for'][$i] = $looking_for;
                $res['when_to_start'][$i] = $when_to_start;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function AddBlogs($username,$blog_heading,$description,$category,$featured_image,$meta_keywords,$meta_description,$slug_url){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('INSERT INTO blog (username,blog_heading,description,category,featured_image,meta_keywords,meta_description,slug_url) values (?,?,?,?,?,?,?,?)');
        $query->bind_param('ssssssss',$username,$blog_heading,$description,$category,$featured_image,$meta_keywords,$meta_description,$slug_url);
        if($query->execute()){
            $res['status']=1;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }
    public function AddTasks($task_date,$domain,$task_name,$task_description,$tasks){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('INSERT INTO addtasks (task_date,domain,task_name,task_description,tasks) values (?,?,?,?,?)');
        $query->bind_param('sssss',$task_date,$domain,$task_name,$task_description,$tasks);
        if($query->execute()){
            $res['status']=1;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }


public function AddProduct(
    $category_id, $subcategory_id, $product_name, $featured_image, $additional_images, 
    $stock, $ornament_type, $ornament_weight, $discount_percentage, $short_description, 
    $features, $is_lakshmi_kubera, $is_popular_collection, $is_recommended, 
    $general_info, $description, $attribute_ids, $variation_names, 
    $variation_same_prices, $variation_ornament_weights, $variation_discounted_percentages
) {
    $res = array();
    $res['status'] = 0;

    // Database connection setup
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    $con->begin_transaction();

    try {
        // Insert the main product
        $product_code = '123';
        $query = $con->prepare('INSERT INTO products (category_id, subcategory_id, product_code, product_name, featured_image, additional_images, stock, ornament_type, ornament_weight, discount_percentage, short_description, features, is_lakshmi_kubera, is_popular_collection, is_recommended, general_info, description) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
        $query->bind_param('sssssssssssssssss', $category_id, $subcategory_id, $product_code, $product_name, $featured_image, $additional_images, $stock, $ornament_type, $ornament_weight, $discount_percentage, $short_description, $features, $is_lakshmi_kubera, $is_popular_collection, $is_recommended, $general_info, $description);

        if ($query->execute()) {
            $product_id = $con->insert_id;

            // Prepare the insert query for product variations
            $variationQuery = $con->prepare('INSERT INTO product_variations (product_id, attribute_id, variation_name, is_same_price, ornament_weight, discounted_percentage) VALUES (?, ?, ?, ?, ?, ?)');
            
            $product_id = $con->insert_id;

            // Prepare the insert query for product variations
            $variationQuery = $con->prepare('INSERT INTO product_variations (product_id, attribute_id, variation_name, is_same_price, ornament_weight, discount_percentage) VALUES (?, ?, ?, ?, ?, ?)');
            
            foreach ($attribute_ids as $key => $attribute_id) {
                // Check if variations exist for the current attribute
                if (isset($variation_names[$key]) && is_array($variation_names[$key])) {
                    foreach ($variation_names[$key] as $i => $variation_name) {
                        // Retrieve the corresponding values for the current variation
                        $is_same_price = isset($variation_same_prices[$key][$i]) ? 1 : 0;  // Assume checkbox returns a 1 when checked
                        $variation_weight = $variation_ornament_weights[$key][$i] ?? null;  // Use null coalescing operator
                        $variation_discounted_percentage = $variation_discounted_percentages[$key][$i] ?? null;  // Use null coalescing operator
            
                        // Bind parameters and execute the query
                        $variationQuery->bind_param('iissss', $product_id, $attribute_id, $variation_name, $is_same_price, $variation_weight, $variation_discounted_percentage);
                        if (!$variationQuery->execute()) {
                            throw new Exception('Variation insert failed: ' . $variationQuery->error);
                        }
                    }
                }
            }
            

            // Commit transaction
            $con->commit();
            $res['status'] = 1;
        } else {
            $con->rollback();
            $res['error'] = 'Product insert failed: ' . $query->error;
        }
    } catch (Exception $e) {
        // Rollback transaction if any error occurs
        $con->rollback();
        $res['error'] = $e->getMessage();
    }

    // Close the connection
    $con->close();
    return $res;
}

    
    
    


public function getCategorySubcategories($categoryId) {
    $subcategories = [];
    
    if (empty($categoryId)) {
        return $subcategories;
    }
    
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    // Query to get subcategories with product counts
    $query = "SELECT s.id, s.name, COUNT(p.id) AS count 
              FROM sub_categories s
              LEFT JOIN products p ON FIND_IN_SET(s.id, p.subcategory_id) > 0
              WHERE s.category_id = ? AND p.verification_status = 'approved'
              GROUP BY s.id, s.name
              ORDER BY count DESC, s.name ASC";
    
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $subcategories[] = $row;
    }
    
    $stmt->close();
    $con->close();
    
    return $subcategories;
}

public function addOrderItem($itemData) {
    $res = array();
    $res['status'] = 0;

    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    if ($con->connect_error) {
        throw new Exception("Connection failed: " . $con->connect_error);
    }

    try {
        $query = $con->prepare("INSERT INTO order_items (
            order_id, 
            product_id, 
            price
        ) VALUES (?, ?, ?)");
        
        $query->bind_param("iid",
            $itemData['order_id'],
            $itemData['product_id'],
            $itemData['price']
        );

        if ($query->execute()) {
            $res['status'] = 1;
            $res['item_id'] = $con->insert_id;
        } else {
            throw new Exception("Failed to add order item: " . $query->error);
        }

    } catch (Exception $e) {
        $res['error'] = $e->getMessage();
    }

    $query->close();
    $con->close();
    return $res;
}

public function clearCart($user_id) {
    $res = array();
    $res['status'] = 0;

    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    if ($con->connect_error) {
        throw new Exception("Connection failed: " . $con->connect_error);
    }

    try {
        $query = $con->prepare("DELETE FROM cart WHERE user_id = ?");
        $query->bind_param("i", $user_id);

        if ($query->execute()) {
            $res['status'] = 1;
            $res['message'] = 'Cart cleared successfully';
        } else {
            throw new Exception("Failed to clear cart: " . $query->error);
        }

    } catch (Exception $e) {
        $res['error'] = $e->getMessage();
    }

    $query->close();
    $con->close();
    return $res;
}


public function createOrder($orderData) {
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    if ($con->connect_error) {
        throw new Exception("Connection failed: " . $con->connect_error);
    }

    try {
        $con->begin_transaction();

        $query = $con->prepare("INSERT INTO orders (
            user_id, 
            razorpay_payment_id, 
            amount, 
            status, 
            payment_status, 
            billing_name, 
            billing_email, 
            billing_phone,
            billing_address, 
            created_at
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        if (!$query) {
            throw new Exception("Query preparation failed: " . $con->error);
        }

        $query->bind_param("isdsssssss", 
            $orderData['user_id'],
            $orderData['razorpay_payment_id'],
            $orderData['amount'],
            $orderData['status'],
            $orderData['payment_status'],
            $orderData['billing_name'],
            $orderData['billing_email'],
            $orderData['billing_phone'],
            $orderData['billing_address'],
            $orderData['created_at']
        );

        if (!$query->execute()) {
            throw new Exception("Order creation failed: " . $query->error);
        }

        $orderId = $con->insert_id;
        $con->commit();
        
        $query->close();
        $con->close();
        
        return $orderId;

    } catch (Exception $e) {
        if (isset($con)) {
            $con->rollback();
            $con->close();
        }
        throw $e;
    }
}


public function getProductBySlug($slug) {
    $res = array();
    $res['status'] = 0;
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

    // Updated query to include follower and following counts
    $query = $con->prepare("SELECT 
        p.*, 
        c.name AS category_name,
        a.name AS uploader_name,
        a.profile_img AS uploader_profile_img,
        a.created_at AS uploader_joined,
        (SELECT COUNT(*) FROM user_follows WHERE following_id = p.uploader_id) as uploader_followers,
        (SELECT COUNT(*) FROM user_follows WHERE follower_id = p.uploader_id) as uploader_following,
        (SELECT COUNT(*) FROM products WHERE uploader_id = p.uploader_id AND status = 1) as uploader_items,
        (SELECT AVG(rating) FROM reviews WHERE product_id IN 
            (SELECT id FROM products WHERE uploader_id = p.uploader_id)
        ) as uploader_rating
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    LEFT JOIN admin a ON p.uploader_id = a.id
    WHERE p.slug = ? AND p.status = 1");

    $query->bind_param("s", $slug);
    
    if ($query->execute()) {
        $result = $query->get_result();
        if ($row = $result->fetch_assoc()) {
            // Format the counts and ratings
            $row['uploader_followers'] = (int)$row['uploader_followers'];
            $row['uploader_following'] = (int)$row['uploader_following'];
            $row['uploader_items'] = (int)$row['uploader_items'];
            $row['uploader_rating'] = number_format((float)$row['uploader_rating'], 1);
            
            // Format dates
            $row['formatted_created_date'] = date('M d, Y', strtotime($row['created_at']));
            $row['formatted_updated_date'] = date('M d, Y', strtotime($row['updated_at']));
            
            // Get related products
            $row['related_products'] = $this->getRelatedProducts($row['id'], $row['category_id'], $slug, $con);
            
            // Get subcategories
            $row['subcategories'] = $this->getProductSubcategories($row['category_id'], $con);
            
            $res = array_merge($res, $row);
            $res['status'] = 1;
            
            // Increment view count
            $this->incrementProductViews($slug, $con);
        }
    }

    $query->close();
    $con->close();
    return $res;
}

private function getRelatedProducts($productId, $categoryId, $slug, $con) {
    $relatedProducts = [];
    
    $relatedQuery = $con->prepare(
        "SELECT id, product_name, featured_image, slug, product_price, discounted_price 
        FROM products 
        WHERE category_id = ? AND slug != ? AND status = 1
        ORDER BY views DESC LIMIT 4"
    );
    
    if (!$relatedQuery) {
        return $relatedProducts;
    }
    
    $relatedQuery->bind_param("is", $categoryId, $slug);
    $relatedQuery->execute();
    $relatedResult = $relatedQuery->get_result();
    
    while ($related = $relatedResult->fetch_assoc()) {
        $relatedProducts[] = $related;
    }
    
    $relatedQuery->close();
    return $relatedProducts;
}

private function getProductSubcategories($categoryId, $con) {
    $subcategories = [];
    $subcatQuery = $con->prepare("SELECT id, name FROM sub_categories WHERE category_id = ? AND status = 1");
    $subcatQuery->bind_param("i", $categoryId);
    $subcatQuery->execute();
    $subcatResult = $subcatQuery->get_result();
    
    while ($subcat = $subcatResult->fetch_assoc()) {
        $subcategories[] = $subcat;
    }
    
    $subcatQuery->close();
    return $subcategories;
}

public function getProductReviews($product_id, $con = null) {
    $reviews = array();
    $closeConnection = false;
    
    if ($con === null) {
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $closeConnection = true;
    }
    
    // Check if reviews table exists
    $tableExists = $con->query("SHOW TABLES LIKE 'reviews'");
    if ($tableExists->num_rows == 0) {
        // Create reviews table if it doesn't exist
        $con->query("CREATE TABLE IF NOT EXISTS reviews (
            id INT AUTO_INCREMENT PRIMARY KEY,
            product_id INT NOT NULL,
            user_id INT NOT NULL,
            rating DECIMAL(2,1) NOT NULL,
            review_title VARCHAR(255) NOT NULL,
            review_content TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            status TINYINT(1) DEFAULT 1,
            FOREIGN KEY (product_id) REFERENCES products(id),
            FOREIGN KEY (user_id) REFERENCES admin(id)
        )");
        
        // Insert dummy reviews
        $dummyReviews = array(
            array(
                'product_id' => $product_id,
                'user_id' => 1,
                'rating' => 5.0,
                'review_title' => 'Excellent quality and customizable',
                'review_content' => 'This template was exactly what I needed for my project. The layers are well organized, and it was easy to customize. The seller also responded quickly when I had questions about font usage.'
            ),
            array(
                'product_id' => $product_id,
                'user_id' => 1,
                'rating' => 4.0,
                'review_title' => 'Good design but needed more variations',
                'review_content' => 'The design quality is great and professional looking. I just wish there were more color variations included. Had to spend some time creating my own color schemes, but overall very satisfied with the purchase.'
            ),
            array(
                'product_id' => $product_id,
                'user_id' => 1,
                'rating' => 4.5,
                'review_title' => 'Perfect for my business needs',
                'review_content' => 'I used this for my small business and it looks very professional. The design elements are modern and clean. I\'m not a designer but was able to customize it easily. Highly recommended for anyone looking for quality design templates.'
            )
        );
        
        $stmt = $con->prepare("INSERT INTO reviews (product_id, user_id, rating, review_title, review_content) VALUES (?, ?, ?, ?, ?)");
        foreach ($dummyReviews as $review) {
            $stmt->bind_param("iidss", $review['product_id'], $review['user_id'], $review['rating'], $review['review_title'], $review['review_content']);
            $stmt->execute();
        }
        $stmt->close();
    }
    
    // Get reviews
    $query = $con->prepare("
        SELECT r.*, a.name as reviewer_name, a.profile_img as reviewer_image
        FROM reviews r
        LEFT JOIN admin a ON r.user_id = a.id
        WHERE r.product_id = ? AND r.status = 1
        ORDER BY r.created_at DESC
    ");
    
    $query->bind_param("i", $product_id);
    if ($query->execute()) {
        $result = $query->get_result();
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }
    }
    
    $query->close();
    if ($closeConnection) {
        $con->close();
    }
    
    return $reviews;
}

private function incrementProductViews($slug, $con) {
    $updateViews = $con->prepare("UPDATE products SET views = views + 1 WHERE slug = ?");
    $updateViews->bind_param("s", $slug);
    $updateViews->execute();
    $updateViews->close();
}


public function getFollowersCount($user_id) {
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    $query = $con->prepare("SELECT COUNT(*) as count FROM user_follows WHERE following_id = ?");
    $query->bind_param('i', $user_id);
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_assoc();
    return $row['count'] ?? 0;
}

public function getFollowingCount($user_id) {
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    $query = $con->prepare("SELECT COUNT(*) as count FROM user_follows WHERE follower_id = ?");
    $query->bind_param('i', $user_id);
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_assoc();
    return $row['count'] ?? 0;
}



public function formatDate($date) {
    if (empty($date)) return '';
    $dateObj = new DateTime($date);
    return $dateObj->format('d M Y');
}

public function extractYoutubeId($url) {
    if (empty($url)) return '';
    
    $videoId = '';
    if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $matches)) {
        $videoId = $matches[1];
    } else if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $matches)) {
        $videoId = $matches[1];
    } else if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $matches)) {
        $videoId = $matches[1];
    }
    
    return $videoId;
}

public function getMenuCategories() {
    $res = array();
    $res['status'] = 0;
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    $query = $con->prepare("SELECT 
        c.id AS category_id,
        c.name AS category_name,
        c.image AS category_image,
        s.id AS subcategory_id,
        s.name AS subcategory_name,
        p.id AS product_id,
        p.product_name,
        p.featured_image,
        p.product_price,
        p.discount_percentage,
        p.discounted_price,
        p.slug
    FROM categories c
    LEFT JOIN sub_categories s ON s.category_id = c.id
    LEFT JOIN products p ON p.category_id = c.id
    WHERE c.status = 1
    ORDER BY c.id, s.id, p.id");

    if ($query->execute()) {
        $result = $query->get_result();
        $categories = array();
        
        while ($row = $result->fetch_assoc()) {
            $catId = $row['category_id'];
            
            // Initialize category if not exists
            if (!isset($categories[$catId])) {
                $categories[$catId] = array(
                    'id' => $catId,
                    'name' => $row['category_name'],
                    'image' => $row['category_image'],
                    'subcategories' => array(),
                    'products' => array()
                );
            }
            
            // Add subcategory if exists and not already added
            if ($row['subcategory_id'] && !isset($categories[$catId]['subcategories'][$row['subcategory_id']])) {
                $categories[$catId]['subcategories'][$row['subcategory_id']] = array(
                    'id' => $row['subcategory_id'],
                    'name' => $row['subcategory_name']
                );
            }
            
            // Add product if exists
            if ($row['product_id']) {
                $categories[$catId]['products'][] = array(
                    'id' => $row['product_id'],
                    'name' => $row['product_name'],
                    'featured_image' => $row['featured_image'],
                    'price' => $row['product_price'],
                    'discounted_price' => $row['discounted_price'],
                    'slug' => $row['slug']
                );
            }
        }
        
        // Convert to indexed array for consistency
        $i = 0;
        foreach ($categories as $category) {
            $res['id'][$i] = $category['id'];
            $res['name'][$i] = $category['name'];
            $res['image'][$i] = $category['image'];
            $res['subcategories'][$i] = array_values($category['subcategories']);
            $res['products'][$i] = $category['products'];
            $i++;
        }
        
        $res['status'] = 1;
        $res['count'] = $i;
    }

    $query->close();
    $con->close();
    return $res;


    
}





public function getTotalPurchases($productId = null) {
    $totalPurchases = 0;
    
    try {
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        if ($con->connect_error) {
            error_log("Connection failed: " . $con->connect_error);
            return $totalPurchases;
        }
        
        // If a product ID is provided, get purchases for that specific product
        if ($productId) {
            // First, check if the table exists
            $tableCheck = $con->query("SHOW TABLES LIKE 'order_item'");
            if ($tableCheck->num_rows > 0) {
                $query = "SELECT COUNT(*) as total FROM order_item WHERE product_id = ?";
            } else {
                // Try the alternative table name that might be used
                $query = "SELECT COUNT(*) as total FROM sales WHERE product_id = ? AND payment_status = 'completed'";
            }
            
            $stmt = $con->prepare($query);
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result && $row = $result->fetch_assoc()) {
                $totalPurchases = (int)$row['total'];
            }
            
            $stmt->close();
            
            // If still zero, try checking other possible tables
            if ($totalPurchases == 0) {
                $tables = ['orders', 'order_products', 'sales'];
                
                foreach ($tables as $table) {
                    $tableCheck = $con->query("SHOW TABLES LIKE '$table'");
                    if ($tableCheck->num_rows > 0) {
                        // Check if this table has the product_id column
                        $columnCheck = $con->query("SHOW COLUMNS FROM $table LIKE 'product_id'");
                        if ($columnCheck->num_rows > 0) {
                            $query = "SELECT COUNT(*) as total FROM $table WHERE product_id = ?";
                            $stmt = $con->prepare($query);
                            $stmt->bind_param("i", $productId);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            
                            if ($result && $row = $result->fetch_assoc()) {
                                $totalPurchases = (int)$row['total'];
                                if ($totalPurchases > 0) break; // If we found purchases, stop looking
                            }
                            
                            $stmt->close();
                        }
                    }
                }
            }
        } else {
            // Get total purchases across all products
            $tableCheck = $con->query("SHOW TABLES LIKE 'order_item'");
            if ($tableCheck->num_rows > 0) {
                $result = $con->query("SELECT COUNT(*) as total FROM order_item");
            } else {
                $result = $con->query("SELECT COUNT(*) as total FROM sales WHERE payment_status = 'completed'");
            }
            
            if ($result && $row = $result->fetch_assoc()) {
                $totalPurchases = (int)$row['total'];
            }
        }
        
        $con->close();
    } catch (Exception $e) {
        error_log("Error in getTotalPurchases: " . $e->getMessage());
    }
    
    
    return $totalPurchases;
}

public function getFollowedUserProjects($user_id) {
    $res = array(
        'status' => 0,
        'count' => 0,
        'id' => array(),
        'uploader_id' => array(),
        'uploader_name' => array(),
        'category_id' => array(),
        'category_name' => array(),
        'subcategory_ids' => array(),
        'subcategory_names' => array(),
        'product_name' => array(),
        'featured_image' => array(),
        'short_description' => array(),
        'description' => array(),
        'youtube_url' => array(),
        'project_files_zip' => array(),
        'project_link' => array(),
        'product_price' => array(),
        'discount_percentage' => array(),
        'discounted_price' => array(),
        'is_popular_collection' => array(),
        'is_recommended' => array(),
        'slug' => array(),
        'status' => array(),
        'views' => array(),
        'downloads' => array(),
        'verification_status' => array(),
        'created_at' => array(),
        'updated_at' => array()
    );

    try {
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        if ($con->connect_error) {
            return $res;
        }

        // Get products from users that the current user follows
        $query = $con->prepare("
            SELECT 
                p.*, 
                c.name AS category_name,
                a.name AS uploader_name
            FROM products p
            INNER JOIN user_follows uf ON p.uploader_id = uf.following_id
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN admin a ON p.uploader_id = a.id
            WHERE uf.follower_id = ? 
            AND p.status = 1 
            AND p.verification_status = 'approved'
            ORDER BY p.created_at DESC
        ");

        if (!$query) {
            return $res;
        }

        $query->bind_param('i', $user_id);

        if ($query->execute()) {
            $result = $query->get_result();
            $i = 0;
            
            while ($row = $result->fetch_assoc()) {
                foreach ($row as $key => $value) {
                    if (isset($res[$key])) {
                        $res[$key][$i] = $value;
                    }
                }
                
                // Handle subcategories
                $subcategories = array();
                $subcategory_names = array();
                if (!empty($row['subcategory_id'])) {
                    $subcatIds = explode(',', $row['subcategory_id']);
                    foreach ($subcatIds as $subcatId) {
                        $subcategories[] = trim($subcatId);
                    }
                }
                $res['subcategory_ids'][$i] = $subcategories;
                $res['subcategory_names'][$i] = $subcategory_names;
                
                $i++;
            }
            $res['count'] = $i;
            if ($i > 0) {
                $res['status'] = 1;
            }
        }

        $query->close();
        $con->close();
        
    } catch (Exception $e) {
        error_log("Error in getFollowedUserProjects: " . $e->getMessage());
    }
    
    return $res;
}


public function AddSubscription($email) {
    $res = array();
    $res['status'] = 0;

    try {
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        if ($con->connect_error) {
            throw new Exception("Connection failed: " . $con->connect_error);
        }
        
        // Check if email already exists
        $checkQuery = $con->prepare("SELECT id FROM subscriptions WHERE email = ?");
        $checkQuery->bind_param('s', $email);
        $checkQuery->execute();
        $checkResult = $checkQuery->get_result();
        
        if ($checkResult->num_rows > 0) {
            $res['status'] = 0;
            $res['error'] = 'You are already subscribed with this email address';
            $checkQuery->close();
            $con->close();
            return $res;
        }
        
        $checkQuery->close();
        
        // Insert new subscription
        $query = $con->prepare("INSERT INTO subscriptions (email) VALUES (?)");
        $query->bind_param('s', $email);
        
        if ($query->execute()) {
            $res['status'] = 1;
            $res['message'] = 'Thank you for subscribing to our newsletter!';
        } else {
            throw new Exception("Failed to save subscription: " . $query->error);
        }
        
        $query->close();
        $con->close();
        
    } catch (Exception $e) {
        $res['error'] = $e->getMessage();
        error_log("Error in AddSubscription: " . $e->getMessage());
    }

    return $res;
}
public function getUserAbout($user_id) {
    $res = array();
    
    try {
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        if ($con->connect_error) {
            return $res;
        }
        
        $query = $con->prepare("SELECT * FROM user_about WHERE user_id = ?");
        $query->bind_param("i", $user_id);
        
        if ($query->execute()) {
            $result = $query->get_result();
            if ($result->num_rows > 0) {
                $res = $result->fetch_assoc();
            }
        }
        
        $query->close();
        $con->close();
    } catch (Exception $e) {
        error_log("Error in getUserAbout: " . $e->getMessage());
    }
    
    return $res;
}
public function getProducts($exclude_user_id = null) {
    $res = array(
        'status' => 0,
        'count' => 0,
        'id' => array(),
        'uploader_id' => array(),
        'uploader_name' => array(),
        'category_id' => array(),
        'category_name' => array(),
        'subcategory_ids' => array(),
        'subcategory_names' => array(),
        'product_name' => array(),
        'featured_image' => array(),
        'short_description' => array(),
        'description' => array(),
        'youtube_url' => array(),
        'project_files_zip' => array(),
        'project_link' => array(),
        'product_price' => array(),
        'discount_percentage' => array(),
        'discounted_price' => array(),
        'is_popular_collection' => array(),
        'is_recommended' => array(),
        'slug' => array(),
        'status' => array(),
        'views' => array(),
        'downloads' => array(),
        'verification_status' => array(),
        'verified_by' => array(),
        'verification_date' => array(),
        'verification_notes' => array(),
        'created_at' => array(),
        'updated_at' => array()
    );

    try {
        // Get database credentials
        $host = $this->hostName();
        $user = $this->userName();
        $pass = $this->password();
        $db = $this->dbName();
        
        // Log connection attempt
        error_log("Attempting database connection to: $host, database: $db");
        
        $con = new mysqli($host, $user, $pass, $db);
        
        if ($con->connect_error) {
            throw new Exception("Database connection failed: " . $con->connect_error);
        }
        
        error_log("Database connection successful");

        $query_str = "SELECT 
            p.*, 
            c.name AS category_name,
            a.name AS uploader_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            LEFT JOIN admin a ON p.uploader_id = a.id
            WHERE p.status = 1";

        if ($exclude_user_id !== null) {
            $query_str .= " AND p.uploader_id != ?";
        }
        
        $query_str .= " ORDER BY p.id DESC";

        error_log("Preparing query: " . $query_str);
        
        $query = $con->prepare($query_str);

        if (!$query) {
            throw new Exception("Query preparation failed: " . $con->error);
        }

        if ($exclude_user_id !== null) {
            $query->bind_param("i", $exclude_user_id);
        }

        if (!$query->execute()) {
            throw new Exception("Query execution failed: " . $query->error);
        }

        $result = $query->get_result();
        $i = 0;
        
        while ($row = $result->fetch_assoc()) {
            foreach ($row as $key => $value) {
                if (isset($res[$key])) {
                    $res[$key][$i] = $value;
                }
            }
            
            // Handle subcategories separately
            $subcategories = array();
            $subcategory_names = array();
            if (!empty($row['subcategory_id'])) {
                $subcatIds = explode(',', $row['subcategory_id']);
                foreach ($subcatIds as $subcatId) {
                    $subcategories[] = trim($subcatId);
                }
            }
            $res['subcategory_ids'][$i] = $subcategories;
            $res['subcategory_names'][$i] = $subcategory_names;
            $i++;
        }
        $res['count'] = $i;
        if ($i > 0) {
            $res['status'] = 1;
        }

        error_log("Query executed successfully. Found $i products.");

        $query->close();
        $con->close();
        
    } catch (Exception $e) {
        error_log("Error in getProducts: " . $e->getMessage());
        if (isset($query)) $query->close();
        if (isset($con)) $con->close();
        throw $e; // Re-throw the exception to be caught by the API endpoint
    }
    
    return $res;
}



public function getProductBySubCatId($id) {
    $res = array();
    $res['status'] = 0;
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

    $query = $con->prepare("
        SELECT 
            products.id, 
            categories.id AS category_id, 
            categories.name AS category_name, 
            sub_categories.id AS subcategory_id, 
            sub_categories.name AS subcategory_name, 
            products.product_code, 
            products.product_name, 
            products.featured_image, 
            products.additional_images, 
            products.stock, 
            ornaments.id AS ornament_id, 
            ornaments.name AS ornament_name,
            products.product_price,
            products.discounted_price,
            products.discount_percentage, 
            GROUP_CONCAT(DISTINCT features.name SEPARATOR ', ') AS features, 
            products.is_lakshmi_kubera, 
            products.is_popular_collection, 
            products.is_recommended, 
            products.general_info, 
            products.description, 
            products.slug, 
            products.status, 
            products.created_at
        FROM 
            products
        LEFT JOIN categories ON products.category_id = categories.id
        LEFT JOIN sub_categories ON products.subcategory_id = sub_categories.id
        LEFT JOIN ornaments ON products.ornament_type = ornaments.id
        LEFT JOIN features ON FIND_IN_SET(features.id, products.features) > 0
        WHERE 
            products.subcategory_id = ? AND products.status = 1
        GROUP BY products.id
        ORDER BY products.id DESC"
    );
            
    $query->bind_param('s', $id);

    if ($query->execute()) {
        $query->bind_result(
            $id, $category_id, $category_name, $subcategory_id, $subcategory_name, 
            $product_code, $product_name, $featured_image, $additional_images, $stock, 
            $ornament_id, $ornament_type, $product_price, $discounted_price, 
            $discount_percentage, $features, $is_lakshmi_kubera, $is_popular_collection, 
            $is_recommended, $general_info, $description, $slug, $status, $created_at
        );

        $i = 0;
        $ornament_counts = [];
        $lakshmi_kubera_count = 0;
        $highest_price = 0; // Initialize highest price tracker

        while ($query->fetch()) {
            if ($is_lakshmi_kubera == 1) {
                $lakshmi_kubera_count++;
            }
            
            $res['status'] = 1;
            $res['id'][$i] = $id;
            $res['category_id'][$i] = $category_id;
            $res['category_name'][$i] = $category_name;
            $res['subcategory_id'][$i] = $subcategory_id;
            $res['subcategory_name'][$i] = $subcategory_name;
            $res['product_code'][$i] = $product_code;
            $res['product_name'][$i] = $product_name;
            $res['featured_image'][$i] = $featured_image;
            $res['additional_images'][$i] = $additional_images;
            $res['stock'][$i] = $stock;
            $res['ornament_id'][$i] = $ornament_id;
            $res['ornament_type'][$i] = $ornament_type;
            $res['actual_price'][$i] = $product_price;
            $res['discounted_price'][$i] = $discounted_price;
            $res['discount_percentage'][$i] = $discount_percentage;
            $res['features'][$i] = $features;
            $res['is_lakshmi_kubera'][$i] = $is_lakshmi_kubera;
            $res['is_popular_collection'][$i] = $is_popular_collection;
            $res['is_recommended'][$i] = $is_recommended;
            $res['general_info'][$i] = $general_info;
            $res['description'][$i] = $description;
            $res['slug'][$i] = $slug;
            $res['statusval'][$i] = $status;
            $res['created_at'][$i] = $created_at;

            // Track highest price
            if ($discounted_price > $highest_price) {
                $highest_price = $discounted_price;
            }

            if (!isset($ornament_counts[$ornament_type])) {
                $ornament_counts[$ornament_type] = 0;
            }
            $ornament_counts[$ornament_type]++;

            $i++;
        }
        
        $res['count'] = $i;
        $res['lakshmi_kubera_count'] = $lakshmi_kubera_count;
        $res['highest_product_price'] = $highest_price; // Set the highest price found
        $res['ornament_counts'] = [];
        
        foreach ($ornament_counts as $type => $count) {
            $res['ornament_counts'][] = [$type, $count];
        }
    } else {
        $res['error'] = 'Statement not Executed';
    }

    $query->close();
    $con->close();
    return $res;
}
    public function UpdateProduct($category_id, $subcategory_id, $product_name, $featured_image, $additional_images, $stock, $ornament_type, $ornament_weight, $discount_percentage, $short_description, 
    $features, $is_lakshmi_kubera, $is_popular_collection, $is_recommended, 
    $general_info, $description,$id) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('UPDATE products SET category_id=?, subcategory_id=?, product_code=?, product_name=?, featured_image=?, additional_images=?, stock=?, ornament_type=?, ornament_weight=?, discount_percentage=?, short_description=?, features=?, is_lakshmi_kubera=?, is_popular_collection=?, is_recommended=?, general_info=?, description=? WHERE id=?');
            $query->bind_param('ssssssssssssssssss',  $category_id, $subcategory_id, $product_code, $product_name, $featured_image, $additional_images, $stock, $ornament_type, $ornament_weight, $discount_percentage, $short_description, $features, $is_lakshmi_kubera, $is_popular_collection, $is_recommended, $general_info, $description,$id);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function getProductVariations($id){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare("SELECT product_variations.id, product_variations.product_id, attributes.id,attributes.name AS attribute_name, product_variations.variation_name, product_variations.is_same_price, product_variations.ornament_weight, product_variations.discount_percentage, product_variations.status,product_variations.created_at
        FROM product_variations
        JOIN attributes ON product_variations.attribute_id = attributes.id
        WHERE product_variations.product_id=?
        ");
        $query->bind_param('i',$id);

        if($query->execute()){
            $query->bind_result($id,$product_id, $attribute_id, $attribute_name, $variation_name, $is_same_price, $ornament_weight, $discount_percentage, $status, $created_at);
            $i=0;
            while($query->fetch()){
                $res['status']=1;
                $res['id'][$i] = $id;
                $res['product_id'][$i] = $product_id;
                $res['attribute_id'][$i] = $attribute_id;
                $res['attribute_name'][$i] = $attribute_name;
                $res['variation_name'][$i] = $variation_name;
                $res['is_same_price'][$i] = $is_same_price;
                $res['ornament_weight'][$i] = $ornament_weight;
                $res['discount_percentage'][$i] = $discount_percentage;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }


    public function getAdvertisements(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT id,name,image,description,url,location,status,created_at FROM advertisements ORDER BY id DESC');
        if($query->execute()){
            $query->bind_result($id,$name, $image, $description,$url,$location, $status, $created_at);
            $i=0;
            while($query->fetch()){
                $res['status']=1;
                $res['id'][$i] = $id;
                $res['name'][$i] = $name;
                $res['image'][$i] = $image;
                $res['description'][$i] = $description;
                $res['url'][$i] = $url;
                $res['location'][$i] = $location;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }



    public function AddFeature($name,$image) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('INSERT INTO features (name,image) VALUES (?,?)');
            $query->bind_param('ss', $name,$image);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function getFeatures(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare("SELECT id, name,image, status,created_at FROM features ORDER BY id DESC");

        if($query->execute()){
            $query->bind_result($id,$name,$image, $status, $created_at);
            $i=0;
            while($query->fetch()){
                $res['status']=1;
                $res['id'][$i] = $id;
                $res['name'][$i] = $name;
                $res['image'][$i] = $image;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function UpdateFeature($name,$image,$id) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('UPDATE features SET name=?,image=? WHERE id=?');
            $query->bind_param('sss',  $name,$image,$id);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function AddOrnament($name,$price) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('INSERT INTO ornaments (name,price) VALUES (?,?)');
            $query->bind_param('ss', $name,$price);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'Category statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function AddVariations($product_id,$attribute_id, $variation_name,$is_same_price,$ornament_weight, $discount_percentage) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('INSERT INTO product_variations (product_id,attribute_id,variation_name,is_same_price, ornament_weight,discount_percentage) VALUES (?,?,?,?,?,?)');
            $query->bind_param('ssssss', $product_id,$attribute_id, $variation_name,$is_same_price,$ornament_weight, $discount_percentage);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'Category statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function getOrnaments(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare("SELECT id, name,price, status,created_at FROM ornaments ORDER BY id DESC");

        if($query->execute()){
            $query->bind_result($id,$name,$price, $status, $created_at);
            $i=0;
            while($query->fetch()){
                $res['status']=1;
                $res['id'][$i] = $id;
                $res['name'][$i] = $name;
                $res['price'][$i] = $price;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function UpdateOrnament($name,$price,$id) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('UPDATE ornaments SET name=?,price=? WHERE id=?');
            $query->bind_param('sss',  $name,$price,$id);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function UpdateVariation($id,$attribute_id, $variation_name,$is_same_price,$ornament_weight,$discount_percentage) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('UPDATE product_variations SET attribute_id=?,variation_name=?,is_same_price=?,ornament_weight=?,discount_percentage=? WHERE id=?');
            $query->bind_param('ssssss',  $attribute_id, $variation_name,$is_same_price,$ornament_weight,$discount_percentage,$id);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }


    public function AddAttribute($name) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('INSERT INTO attributes (name) VALUES (?)');
            $query->bind_param('s', $name);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'Category statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function getAttribute(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare("SELECT id, name, status,created_at FROM attributes ORDER BY id DESC");

        if($query->execute()){
            $query->bind_result($id,$name, $status, $created_at);
            $i=0;
            while($query->fetch()){
                $res['status']=1;
                $res['id'][$i] = $id;
                $res['name'][$i] = $name;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function UpdateAttribute($name,$id) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('UPDATE attributes SET name=? WHERE id=?');
            $query->bind_param('ss',  $name,$id);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function UpdateStatus($table,$id,$status) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('UPDATE '.$table.' SET status=? WHERE id=?');
            $query->bind_param('ss',  $status,$id);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function DeleteRecord($table,$id) {
        $res = array();
        $res['status'] = 0;
    
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $con->begin_transaction();
    
        try {
            $query = $con->prepare('DELETE from '.$table.' WHERE id=?');
            $query->bind_param('s',$id);
            
            if ($query->execute()) {
                $con->commit();
                $res['status'] = 1;
            } else {
                $con->rollback();
                $err = 'statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        $con->close();
    
        return $res;
    }

    public function AddSubCategory($category_id,$subcategory_name, $image, $description) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('INSERT INTO sub_categories ( category_id,name, image, description) VALUES (?, ?, ?,?)');
            $query->bind_param('ssss', $category_id,$subcategory_name, $image, $description);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'Category statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    } 

    public function getSubCategories() {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
        // Modified query to include product count for each subcategory
        $query = $con->prepare('
            SELECT 
                sub_categories.id, 
                sub_categories.category_id, 
                sub_categories.name, 
                sub_categories.image, 
                sub_categories.description, 
                sub_categories.status, 
                sub_categories.created_at, 
                categories.name AS category_name,
                COUNT(products.id) AS product_count
            FROM sub_categories
            JOIN categories ON sub_categories.category_id = categories.id
            LEFT JOIN products ON sub_categories.id = products.subcategory_id
            GROUP BY sub_categories.id
            ORDER BY sub_categories.id DESC
        ');
    
        if ($query->execute()) {
            $query->bind_result(
                $id, 
                $category_id, 
                $name, 
                $image, 
                $description, 
                $status, 
                $created_at, 
                $category_name, 
                $product_count
            );
    
            $i = 0;
            while ($query->fetch()) {
                $res['status'] = 1;
                $res['id'][$i] = $id;
                $res['category_id'][$i] = $category_id;
                $res['name'][$i] = $name;
                $res['image'][$i] = $image;
                $res['description'][$i] = $description;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $res['category_name'][$i] = $category_name;
                $res['product_count'][$i] = $product_count; // Adding product count
                $i++;
            }
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }
    

    public function getSubCategoriesAjax($category_id) {
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
        // Query with a condition to filter by category_id
        $query = $con->prepare('
            SELECT sub_categories.id, sub_categories.name, sub_categories.status
            FROM sub_categories
            WHERE sub_categories.category_id = ? AND sub_categories.status = 1
        ');
    
        $query->bind_param('i', $category_id); // Bind category_id
    
        if ($query->execute()) {
            $query->bind_result($id, $name, $status);
            $i = 0;
            while ($query->fetch()) {
                $res['status'] = 1;
                $res['id'][$i] = $id;
                $res['name'][$i] = $name;
                $res['statusval'][$i] = $status;
                $i++;
            }
            $res['count'] = $i;
        } else {
            $res['error'] = 'Statement not Executed';
        }
    
        $con->close();
        return $res;
    }
    


    public function UpdateSubCategory($category_id,$subcategory_name, $image, $description,$id) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('UPDATE sub_categories SET category_id=?,name=?, image=?, description=? WHERE id=?');
            $query->bind_param('sssss', $category_id,$subcategory_name, $image, $description,$id);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function DeleteSubCategory($id) {
        $res = array();
        $res['status'] = 0;
    
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $con->begin_transaction();
    
        try {
            $query = $con->prepare('DELETE from sub_categories WHERE id=?');
            $query->bind_param('s', $id);
            
            if ($query->execute()) {
                $con->commit();
                $res['status'] = 1;
            } else {
                $con->rollback();
                $err = 'statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        $con->close();
    
        return $res;
    }


    public function AddCategory($category_name, $image, $description) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('INSERT INTO categories ( name, image, description) VALUES (?, ?, ?)');
            $query->bind_param('sss', $category_name, $image, $description);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'Category statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function getCategories(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
        // Modified query to include product count for each category
        $query = $con->prepare('
            SELECT categories.id, categories.name, categories.image, categories.description, categories.status, categories.created_at, 
                   COUNT(products.id) AS product_count
            FROM categories
            LEFT JOIN products ON categories.id = products.category_id
            GROUP BY categories.id
            ORDER BY categories.id DESC
        ');
    
        if($query->execute()){
            $query->bind_result($id, $name, $image, $description, $status, $created_at, $product_count);
            $i=0;
            while($query->fetch()){
                $res['status'] = 1;
                $res['id'][$i] = $id;
                $res['name'][$i] = $name;
                $res['image'][$i] = $image;
                $res['description'][$i] = $description;
                $res['statusval'][$i] = $status;
                $res['created_at'][$i] = $created_at;
                $res['product_count'][$i] = $product_count; // Adding product count
                $i++;
            }
            $res['count'] = $i;
        } else {
            $err = 'Statement not Executed';
        }
        return $res;
    }
    


    public function UpdateCategory($category_name, $image, $description,$id) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('UPDATE categories SET name=?, image=?, description=? WHERE id=?');
            $query->bind_param('ssss', $category_name, $image, $description,$id);
            
            if ($query->execute()) {
                
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'Category statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }

    public function DeleteCategory($id) {
        $res = array();
        $res['status'] = 0;
    
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }

        $con->begin_transaction();
    
        try {
            $query = $con->prepare('DELETE from categories WHERE id=?');
            $query->bind_param('s', $id);
            
            if ($query->execute()) {
                $con->commit();
                $res['status'] = 1;
            } else {
                $con->rollback();
                $err = 'statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        $con->close();
    
        return $res;
    }

    public function AddStudents($student_id, $name, $email, $domain) {
        $res = array();
        $res['status'] = 0;
    
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
        
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Insert into users table
            $query = $con->prepare('INSERT INTO users (stud_id, name, email, password, domain) VALUES (?, ?, ?, ?, ?)');
            $query->bind_param('sssss', $student_id, $name, $email, $email, $domain);
            
            if ($query->execute()) {
                // Get the last inserted ID
                $user_id = $con->insert_id;
    
                // Insert into profiles table
                $profile_query = $con->prepare('INSERT INTO profiles (user_id) VALUES (?)');
                $profile_query->bind_param('i', $user_id);
                
                if ($profile_query->execute()) {
                    // Commit transaction
                    $con->commit();
                    $res['status'] = 1;
                } else {
                    // Rollback transaction if profiles insertion fails
                    $con->rollback();
                    $err = 'Profiles statement not executed';
                    $res['error'] = $err;
                }
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $err = 'Users statement not executed';
                $res['error'] = $err;
            }
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }
    
    public function GetAddedTasks(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT id,task_date,domain,task_name,task_description,tasks,status,created_at,updated_at FROM addtasks ORDER BY id DESC');
        
        if($query->execute()){
            $query->bind_result($id,$task_date,$domain,$task_name,$task_description,$tasks,$status,$created_at,$updated_at);
            $i=0;
            while($query->fetch()){
                $res['status']=1;
                $res['id'][$i] = $id;
                $res['task_date'][$i] = $task_date;
                $res['domain'][$i] = $domain;
                $res['task_name'][$i] = $task_name;
                $res['task_description'][$i] = $task_description;
                $res['tasks'][$i] = $tasks;
                $res['status_val'][$i] = $status;
                $res['updated_at'][$i] = $updated_at;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

    public function GetAddedStudents(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT id,stud_id,name,email,password,domain,status,created_at,updated_at FROM users ORDER BY id DESC');
        
        if($query->execute()){
            $query->bind_result($id,$stud_id,$name,$email,$password,$domain,$status,$created_at,$updated_at);
            $i=0;
            while($query->fetch()){
                $res['status']=1;
                $res['id'][$i] = $id;
                $res['stud_id'][$i] = $stud_id;
                $res['name'][$i] = $name;
                $res['email'][$i] = $email;
                $res['password'][$i] = $password;
                $res['domain'][$i] = $domain;
                $res['status_val'][$i] = $status;
                $res['updated_at'][$i] = $updated_at;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }




    // Admin Login 
    public function AdminLogin($username,$password){
        $res = array();
        $res['status']=0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT email,role FROM admin WHERE email=? AND password=?');
        $query ->bind_param('ss',$username,$password);
        if($query ->execute()){
            $query ->bind_result($email,$role);
            while($query ->fetch()){
                $res['status']=1;
                $res['email']=$email;
                $res['role']=$role;
            }
        }else{
            $err = "Statement not Executed";
        }

        $query -> close();
        $con -> close();
        return $res;
    }


    public function getProfile($id){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT name,spouse,children,father,mother,email,mobile,profession,origin,city,state,country,interest,special,photos,instagram,created_at FROM register WHERE status=1 AND id=? ORDER BY id DESC');
        $query->bind_param('s',$id);
        if($query->execute()){
            $query->bind_result($name,$spouse,$children,$father,$mother,$email,$mobile,$profession,$origin,$city,$state,$country,$interest,$special,$photos,$instagram,$created_at);
            while($query->fetch()){
                $res['status'] = 1;
                $res['name'] = $name;
                $res['spouse'] = $spouse;
                $res['children'] = $children;
                $res['father'] = $father;
                $res['mother'] = $mother;
                $res['email'] = $email;
                $res['mobile'] = $mobile;
                $res['profession'] = $profession;
                $res['origin'] = $origin;
                $res['city'] = $city;
                $res['state'] = $state;
                $res['country'] = $country;
                $res['interest'] = $interest;
                $res['special'] = $special;
                $res['photos'] = $photos;
                $res['instagram'] = $instagram;
                $res['created_at'] = $created_at;

            }
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }


    
    public function updateProfile($name,$spouse, $children, $father, $mother, $email,$mobile,$profession,$origin,$city,$state,$country,$interest,$special,$photos,$instagram,$id){
        $res = array();
        $res['status']=0;
        $con = new mysqli($this->hostName(),$this->userName(),$this->password(),$this->dbName() );
        $query = $con->prepare('UPDATE register SET name=?,spouse=?, children=?, father=?, mother=?, email=?,mobile=?,profession=?,origin=?,city=?,state=?,country=?,interest=?,special=?,photos=?,instagram=? WHERE id=?');
        $query->bind_param('sssssssssssssssss',$name,$spouse, $children, $father, $mother, $email,$mobile,$profession,$origin,$city,$state,$country,$interest,$special,$photos,$instagram,$id);
        if ($query->execute()) {
            if(!empty($query ->affected_rows) && $query ->affected_rows >0){
                $res['status']=1;
            }else{
                $err = 'Data not Inserted';
            }
        }

        $con->close();
        $query->close();
        return $res;

    }

    public function RegStatusUpdate($id,$status){
        $res = array();
        $res['status']=0;
        $con = new mysqli($this->hostName(),$this->userName(),$this->password(),$this->dbName() );
        $query = $con->prepare('UPDATE registrations SET status=? WHERE sno=?');
        if($status == 'Inactive'){
            $status='0';
        }else{
            $status='1';
        }
        $query->bind_param('ss',$status,$id);
        if ($query->execute()) {
            if(!empty($query ->affected_rows) && $query ->affected_rows >0){
                $res['status']=1;
            }else{
                $err = 'Data not Inserted';
            }
        }

        $con->close();
        $query->close();
        return $res;

    }

    //Change Password
    public function changepwd($id,$password){
        $res = array();
        $res['status']=0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('UPDATE register set password=? where id=?');
        $query ->bind_param('ss',$password,$id);
        if($query ->execute()){
                $res['status']=1;
        }else{
            $err = "Statement not Executed";
        }

        $query -> close();
        $con -> close();
        return $res;
    }


    // Blogs Submission
    public function blogs($image, $heading, $meta, $description){
        $res =array();
        $res['status']=0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('INSERT INTO blogs (image, heading, description, meta) values (?,?,?,?)');
        $query ->bind_param('ssss',$image, $heading, $description, $meta);
        if($query ->execute()){
            if(!empty($query ->affected_rows) && $query ->affected_rows >0){
                $res['status']=1;
            }else{
                $err = 'Data not Inserted';
            }
        }else{
            $err = 'Statement Not Executed';
        }
        return $res;
    }

    // Clients Submission
    public function clients($client_logo, $client_name){
        $res =array();
        $res['status']=0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('INSERT INTO clients (client_logo, client_name) values (?,?)');
        $query ->bind_param('ss',$client_logo, $client_name);
        if($query ->execute()){
            if(!empty($query ->affected_rows) && $query ->affected_rows >0){
                $res['status']=1;
            }else{
                $err = 'Data not Inserted';
            }
        }else{
            $err = 'Statement Not Executed';
        }
        return $res;
    }

    

    //contacts Retieval



    //Plans Retieval
    public function getPlans(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT pickup_location,drop_location,travel_date,return_date,travellers,name,mobile,email,message,created_at FROM plans ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($pickup_location,$drop_location,$travel_date,$return_date,$travellers,$name,$mobile,$email,$message,$created_at);
            $i=1;
            while($query->fetch()){
                $res['status']=1;
                $res['name'][$i] = $name;
                $res['email'][$i] = $email;
                $res['mobile'][$i] = $mobile;
                $res['message'][$i] = $message;
                $res['pickup_location'][$i] = $pickup_location;
                $res['drop_location'][$i] = $drop_location;
                $res['travel_date'][$i] = $travel_date;
                $res['return_date'][$i] = $return_date;
                $res['travellers'][$i] = $travellers;
                $res['created_at'][$i] = $created_at;
                $res['status']=1;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

    
    //Plans Retieval
    public function bike_rental(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT pickup_location,drop_location,travel_date,return_date,bike_model,name,mobile,email,message,created_at FROM bike_rental ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($pickup_location,$drop_location,$travel_date,$return_date,$bike_model,$name,$mobile,$email,$message,$created_at);
            $i=1;
            while($query->fetch()){
                $res['status']=1;
                $res['name'][$i] = $name;
                $res['email'][$i] = $email;
                $res['mobile'][$i] = $mobile;
                $res['message'][$i] = $message;
                $res['pickup_location'][$i] = $pickup_location;
                $res['drop_location'][$i] = $drop_location;
                $res['travel_date'][$i] = $travel_date;
                $res['return_date'][$i] = $return_date;
                $res['bike_model'][$i] = $bike_model;
                $res['created_at'][$i] = $created_at;
                $res['status']=1;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }


     //Subscribes Retieval
     public function getSubscribes(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT mobile,created_at FROM callbacks ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($mobile, $updatedtime);
            $i=1;
            while($query->fetch()){
                $res['status']=1;
                $res['mobile'][$i] = $mobile;
                $res['updatedtime'][$i] = $updatedtime;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }

      //Blogs Retieval
      public function getBlogsOldAlumni(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT image, heading, meta, description, created_at FROM blogs ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($image, $heading, $meta, $description, $created_at);
            $i=1;
            while($query->fetch()){
                $res['status']=1;
                $res['image'][$i] = $image;
                $res['heading'][$i] = $heading;
                $res['meta'][$i] = $meta;
                $res['description'][$i] = $description;
                $res['created_at'][$i] = $created_at;
                $i++;
            }
            $res['count']=$i;
        }else{

            $err = 'Statement not Executed';
        }
        return $res;
    }


      //Clients Retieval
      public function getClients(){
        $res = array();
        $res['status'] = 0;
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $query = $con->prepare('SELECT client_logo, client_name,updatedtime FROM clients ORDER BY sno DESC');
        if($query->execute()){
            $query->bind_result($client_logo, $client_name, $updatedtime);
            $i=1;
            while($query->fetch()){
                $res['status']=1;
                $res['client_logo'][$i] = $client_logo;
                $res['client_name'][$i] = $client_name;
                $res['updatedtime'][$i] = $updatedtime;
                $i++;
            }
            $res['count']=$i;
        }else{
            $err = 'Statement not Executed';
        }
        return $res;
    }


    public function userRegistration($name, $email, $mobile, $password, $address) {
        $res = array();
        $res['status'] = 0;
        
        // Establish database connection
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
        // Check connection
        if ($con->connect_error) {
            die("Connection failed: " . $con->connect_error);
        }
    
        // Begin transaction
        $con->begin_transaction();
    
        try {
            // Check if email already exists
            $emailQuery = $con->prepare('SELECT id FROM users WHERE email = ?');
            $emailQuery->bind_param('s', $email);
            $emailQuery->execute();
            $emailQuery->store_result();
            if ($emailQuery->num_rows > 0) {
                $res['status'] = 3; // Duplicate email
                $con->rollback();
                $emailQuery->close();
                $con->close();
                return $res;
            }
            $emailQuery->close();
    
            // Check if mobile number already exists
            $mobileQuery = $con->prepare('SELECT id FROM users WHERE mobile = ?');
            $mobileQuery->bind_param('s', $mobile);
            $mobileQuery->execute();
            $mobileQuery->store_result();
            if ($mobileQuery->num_rows > 0) {
                $res['status'] = 4; // Duplicate mobile number
                $con->rollback();
                $mobileQuery->close();
                $con->close();
                return $res;
            }
            $mobileQuery->close();
    
            // Insert into users table
            $query = $con->prepare('INSERT INTO users (name, email, mobile, password, address) VALUES (?, ?, ?, ?, ?)');
            $query->bind_param('sssss', $name, $email, $mobile, $password, $address);
    
            if ($query->execute()) {
                // Commit transaction
                $con->commit();
                $res['status'] = 1;
                $res['user_id'] = $query->insert_id; // Get the last inserted ID
            } else {
                // Rollback transaction if users insertion fails
                $con->rollback();
                $res['error'] = 'Insert statement not executed';
            }
            $query->close();
        } catch (Exception $e) {
            // Rollback transaction in case of error
            $con->rollback();
            $res['error'] = $e->getMessage();
        }
    
        // Close the connection
        $con->close();
    
        return $res;
    }
    

        // User Login 
        public function userLogin($mobile,$password){
            $res = array();
            $res['status']=0;
            $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
            $query = $con->prepare('SELECT id,name,mobile,email FROM users WHERE mobile=? AND password=?');
            $query ->bind_param('ss',$mobile,$password);
            if($query ->execute()){
                $query ->bind_result($id,$name,$mobile,$email);
                while($query ->fetch()){
                    $res['status']=1;
                    $res['user_id']=$id;
                    $res['name']=$name;
                    $res['mobile']=$mobile;
                    $res['email']=$email;
                }
            }else{
                $err = "Statement not Executed";
            }
    
            $query -> close();
            $con -> close();
            return $res;
        }



        public function checkEmailExists($email){
            $res = array();
            $res['status'] = 0;
            
            $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
            
            // Prepare the select query to check for email existence
            $query = $con->prepare('SELECT 1 FROM users WHERE email = ? LIMIT 1');
            $query->bind_param('s', $email);
            $query->execute();
            
            // Check if any result is found
            $query->store_result();
            if($query->num_rows > 0) {
                $res['status'] = 1;  // Email exists
            } else {
                $res['status'] = 0;  // Email not found
            }
            
            $query->close();
            $con->close();
            
            return $res;
        }
        
        
    
        public function ResetPassword($email, $password){
            $res = array();
            $res['status'] = 0;
            $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
            
            // Prepare and execute the update query
            $query = $con->prepare('UPDATE users SET password=? WHERE email=?');
            $query->bind_param('ss', $password, $email);
            $query->execute();
            
            // Check if any rows were affected
            if($query->affected_rows > 0){
                $res['status'] = 1; // Update successful
            } else {
                $res['status'] = 0; // No record was updated, possibly email not found
                $err = 'No matching record found';
            }
            
            $query->close();
            $con->close();
            
            return $res;
        }




public function addToCart($user_id, $product_id, $quantity = 1) {
    $res = array();
    $res['status'] = 0;

    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    if ($con->connect_error) {
        $res['error'] = "Connection failed: " . $con->connect_error;
        return $res;
    }

    try {
        $con->begin_transaction();

        // Check if project already exists in cart
        $checkQuery = $con->prepare('SELECT quantity FROM cart WHERE user_id = ? AND product_id = ? AND status = 1');
        $checkQuery->bind_param('ii', $user_id, $product_id);
        $checkQuery->execute();
        $checkQuery->store_result();

        if ($checkQuery->num_rows > 0) {
            // If project exists, update quantity
            $checkQuery->bind_result($currentQuantity);
            $checkQuery->fetch();
            $newQuantity = $currentQuantity + $quantity;

            $updateQuery = $con->prepare('UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?');
            $updateQuery->bind_param('iii', $newQuantity, $user_id, $product_id);

            if ($updateQuery->execute()) {
                $res['status'] = 2; // Updated existing item
                $res['message'] = 'Cart updated successfully';
                $con->commit();
            } else {
                throw new Exception('Failed to update cart');
            }
        } else {
            // Add new item to cart
            $insertQuery = $con->prepare('INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)');
            $insertQuery->bind_param('iii', $user_id, $product_id, $quantity);

            if ($insertQuery->execute()) {
                $res['status'] = 1; // Added new item
                $res['message'] = 'Added to cart successfully';
                $con->commit();
            } else {
                throw new Exception('Failed to add to cart');
            }
        }

    } catch (Exception $e) {
        $con->rollback();
        $res['error'] = $e->getMessage();
    }

    $con->close();
    return $res;
}

// public function getCartById($user_id) {
//     $res = array();
//     $res['status'] = 0;

//     $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

//     $query = $con->prepare(
//         "SELECT 
//             c.id, 
//             c.product_id, 
//             c.quantity,
//             p.product_name,
//             p.featured_image,
//             p.product_price,
//             p.discount_percentage,
//             p.discounted_price,
//             p.youtube_url,
//             p.slug,
//             p.verification_status
//         FROM cart c
//         INNER JOIN products p ON c.product_id = p.id
//         WHERE c.user_id = ? AND c.status = 1
//         AND p.verification_status = 'approved'
//         ORDER BY c.created_at DESC"
//     );

//     $query->bind_param('i', $user_id);

//     if ($query->execute()) {
//         $result = $query->get_result();
//         $i = 0;
//         while ($row = $result->fetch_assoc()) {
//             $res['status'] = 1;
//             $res['cart_items'][$i] = $row;
//             $i++;
//         }
//         $res['count'] = $i;
//     }

//     $query->close();
//     $con->close();
//     return $res;
// }



// In logics.class.php, modify getCartById function to include uploader_id
public function getCartById($user_id) {
    $res = array();
    $res['status'] = 0;

    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

    $query = $con->prepare(
        "SELECT 
            c.id, 
            c.product_id, 
            c.quantity,
            p.product_name,
            p.featured_image,
            p.product_price,
            p.discount_percentage,
            p.discounted_price,
            p.youtube_url,
            p.slug,
            p.verification_status,
            p.uploader_id   /* Added this line to include uploader_id */
        FROM cart c
        INNER JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ? AND c.status = 1
        AND p.verification_status = 'approved'
        ORDER BY c.created_at DESC"
    );

    $query->bind_param('i', $user_id);

    if ($query->execute()) {
        $result = $query->get_result();
        while ($row = $result->fetch_assoc()) {
            $res['status'] = 1;
            $res['cart_items'][] = $row;
        }
        $res['count'] = count($res['cart_items'] ?? []);
    }

    $query->close();
    $con->close();
    return $res;
}
public function DeleteCartItem($cart_id, $user_id) {
    $res = array();
    $res['status'] = 0;

    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    try {
        $con->begin_transaction();

        $query = $con->prepare('DELETE FROM cart WHERE id = ? AND user_id = ?');
        $query->bind_param('ii', $cart_id, $user_id);

        if ($query->execute() && $query->affected_rows > 0) {
            $res['status'] = 1;
            $res['message'] = 'Item removed from cart';
            $con->commit();
        } else {
            throw new Exception('Failed to remove item from cart');
        }

    } catch (Exception $e) {
        $con->rollback();
        $res['error'] = $e->getMessage();
    }

    $con->close();
    return $res;
}

public function UpdateCartQuantity($cart_id, $quantity, $user_id) {
    $res = array();
    $res['status'] = 0;

    if ($quantity < 1) {
        $res['error'] = 'Invalid quantity';
        return $res;
    }

    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    try {
        $con->begin_transaction();

        $query = $con->prepare('UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?');
        $query->bind_param('iii', $quantity, $cart_id, $user_id);

        if ($query->execute() && $query->affected_rows > 0) {
            $res['status'] = 1;
            $res['message'] = 'Quantity updated successfully';
            $con->commit();
        } else {
            throw new Exception('Failed to update quantity');
        }

    } catch (Exception $e) {
        $con->rollback();
        $res['error'] = $e->getMessage();
    }

    $con->close();
    return $res;
}
       

// Inside logics.class.php

public function addToWishlist($user_id, $product_id) {
    $res = array();
    $res['status'] = 0;

    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    if ($con->connect_error) {
        $res['error'] = "Connection failed: " . $con->connect_error;
        return $res;
    }

    try {
        $con->begin_transaction();

        // Check if product already exists in wishlist
        $checkQuery = $con->prepare('SELECT id FROM wishlist WHERE user_id = ? AND product_id = ? AND status = 1');
        $checkQuery->bind_param('ii', $user_id, $product_id);
        $checkQuery->execute();
        $checkQuery->store_result();

        if ($checkQuery->num_rows > 0) {
            $res['status'] = 2; // Already in wishlist
            $res['message'] = 'Product already in wishlist';
        } else {
            // Add to wishlist
            $insertQuery = $con->prepare('INSERT INTO wishlist (user_id, product_id, status) VALUES (?, ?, 1)');
            $insertQuery->bind_param('ii', $user_id, $product_id);
            
            if ($insertQuery->execute()) {
                $res['status'] = 1;
                $res['message'] = 'Product added to wishlist';
                $con->commit();
            } else {
                throw new Exception('Failed to add product to wishlist');
            }
            $insertQuery->close();
        }
        $checkQuery->close();

    } catch (Exception $e) {
        $con->rollback();
        $res['error'] = $e->getMessage();
    }

    $con->close();
    return $res;
}

public function getWishlistByUserId($user_id) {
    $res = array();
    $res['status'] = 0;

    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

    $query = $con->prepare(
        "SELECT 
            w.id, 
            w.product_id, 
            p.product_name,
            p.featured_image,
            p.product_price,
            p.discount_percentage,
            p.discounted_price,
            p.youtube_url,
            p.slug,
            p.verification_status
        FROM wishlist w
        INNER JOIN products p ON w.product_id = p.id
        WHERE w.user_id = ? AND w.status = 1
        AND p.verification_status = 'approved'
        ORDER BY w.created_at DESC"
    );

    $query->bind_param('i', $user_id);

    if ($query->execute()) {
        $result = $query->get_result();
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $res['status'] = 1;
            $res['wishlist_items'][$i] = $row;
            $i++;
        }
        $res['count'] = $i;
    }

    $query->close();
    $con->close();
    return $res;
}

public function removeFromWishlist($wishlist_id, $user_id) {
    $res = array();
    $res['status'] = 0;

    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    try {
        $con->begin_transaction();

        $query = $con->prepare('DELETE FROM wishlist WHERE id = ? AND user_id = ?');
        $query->bind_param('ii', $wishlist_id, $user_id);

        if ($query->execute() && $query->affected_rows > 0) {
            $res['status'] = 1;
            $res['message'] = 'Item removed from wishlist';
            $con->commit();
        } else {
            throw new Exception('Failed to remove item from wishlist');
        }

    } catch (Exception $e) {
        $con->rollback();
        $res['error'] = $e->getMessage();
    }

    $con->close();
    return $res;
}

public function moveToCart($wishlist_id, $user_id) {
    $res = array();
    $res['status'] = 0;

    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    try {
        $con->begin_transaction();

        // Get product_id from wishlist
        $getQuery = $con->prepare('SELECT product_id FROM wishlist WHERE id = ? AND user_id = ?');
        $getQuery->bind_param('ii', $wishlist_id, $user_id);
        $getQuery->execute();
        $getQuery->store_result();

        if ($getQuery->num_rows > 0) {
            $getQuery->bind_result($product_id);
            $getQuery->fetch();

            // Add to cart
            $cartResult = $this->addToCart($user_id, $product_id, 1);
            
            if ($cartResult['status'] > 0) {
                // Remove from wishlist
                $removeQuery = $con->prepare('DELETE FROM wishlist WHERE id = ? AND user_id = ?');
                $removeQuery->bind_param('ii', $wishlist_id, $user_id);
                
                if ($removeQuery->execute()) {
                    $res['status'] = 1;
                    $res['message'] = 'Item moved to cart successfully';
                    $con->commit();
                } else {
                    throw new Exception('Failed to remove from wishlist');
                }
            } else {
                throw new Exception($cartResult['error'] ?? 'Failed to add to cart');
            }
        } else {
            throw new Exception('Wishlist item not found');
        }

    } catch (Exception $e) {
        $con->rollback();
        $res['error'] = $e->getMessage();
    }

    $con->close();
    return $res;
}



        public function ApplyCoupon($coupon,$grandTotal) {
            $res = array();
            $res['status'] = 0;
            $res['new_total'] = 0;  // Initialize a new total value
            
            // Establish database connection
            $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
            
            // Check connection
            if ($con->connect_error) {
                die("Connection failed: " . $con->connect_error);
            }
            
            // Begin transaction
            $con->begin_transaction();
            
            try {
                // SQL query to select valid coupon (checks expiry and status in the query itself)AND expiry > NOW()
                $query = $con->prepare('
                    SELECT coupon, discount, type 
                    FROM coupons 
                    WHERE coupon = ? 
                    AND status = 1 
                    AND expiry > NOW()
                    
                ');
                $query->bind_param('s', $coupon);
                
                if ($query->execute()) {
                    $result = $query->get_result();
                    
                    // Check if the coupon exists and is valid
                    if ($result->num_rows > 0) {
                        
                        $couponData = $result->fetch_assoc();
                        $res['status'] = 1;
                        $res['discount'] = $couponData['discount'];
                        $res['type'] = $couponData['type'];
                        
                        // Assuming you have a grand total value stored somewhere (e.g., session or database)
                        // Example of calculating new total after applying discount
                        // $grandTotal = $grandTotal; // Placeholder for original total, replace with actual value
                        if ($couponData['type'] == 'percentage') {
                            $res['new_total'] = round($grandTotal - ($grandTotal * ($couponData['discount'] / 100)));
                        } else {
                            $res['new_total'] = round($grandTotal - $couponData['discount']);
                        }
                    } else {
                        $res['error'] = 'Invalid, expired, or inactive coupon code';
                    }
                    
                    // Commit transaction
                    $con->commit();
                } else {
                    // Rollback transaction if query execution fails
                    $con->rollback();
                    $res['error'] = 'Statement execution failed';
                }
            } catch (Exception $e) {
                // Rollback transaction in case of error
                $con->rollback();
                $res['error'] = $e->getMessage();
            }
            
            // Close the connection
            $con->close();
            
            return $res;
        }

public function PlaceOrder($orderData) {
    $res = array();
    $res['status'] = 0;

    try {
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        if ($con->connect_error) {
            throw new Exception("Database connection failed: " . $con->connect_error);
        }

        // Begin transaction
        $con->begin_transaction();

        // Generate unique order ID if not provided
        if (empty($orderData['order_id'])) {
            $orderData['order_id'] = 'ORD' . time() . rand(1000, 9999);
        }

        // For debugging, print the SQL statement
        error_log("Number of columns in INSERT: 38");
        
        // Set default values for optional fields
        $coupon = isset($orderData['coupon']) ? $orderData['coupon'] : '';
        $discount = isset($orderData['discount']) ? $orderData['discount'] : '';
        $coupon_type = isset($orderData['coupon_type']) ? $orderData['coupon_type'] : '';
        
        // Use direct SQL for debugging
        $sql = "INSERT INTO orders (
            order_id, razorpay_order_id, user_id, 
            billing_fullname, billing_email, billing_mobile,
            billing_address1, billing_address2, billing_city,
            billing_state, billing_pincode,
            shipping_fullname, shipping_email, shipping_mobile,
            shipping_address1, shipping_address2, shipping_city,
            shipping_state, shipping_pincode,
            total_products, subtotal, gst, total, grandtotal,
            coupon, discount, coupon_type,
            payment_mode, payment_amount, payment_reference,
            payment_proof, approval, remarks, status,
            payment_id, payment_date, order_status, payment_status
        ) VALUES (
            '{$con->real_escape_string($orderData['order_id'])}',
            '{$con->real_escape_string($orderData['razorpay_order_id'])}',
            '{$con->real_escape_string($orderData['user_id'])}',
            '{$con->real_escape_string($orderData['billing_fullname'])}',
            '{$con->real_escape_string($orderData['billing_email'])}',
            '{$con->real_escape_string($orderData['billing_mobile'])}',
            '{$con->real_escape_string($orderData['billing_address1'])}',
            '{$con->real_escape_string($orderData['billing_address2'])}',
            '{$con->real_escape_string($orderData['billing_city'])}',
            '{$con->real_escape_string($orderData['billing_state'])}',
            '{$con->real_escape_string($orderData['billing_pincode'])}',
            '{$con->real_escape_string($orderData['shipping_fullname'])}',
            '{$con->real_escape_string($orderData['shipping_email'])}',
            '{$con->real_escape_string($orderData['shipping_mobile'])}',
            '{$con->real_escape_string($orderData['shipping_address1'])}',
            '{$con->real_escape_string($orderData['shipping_address2'])}',
            '{$con->real_escape_string($orderData['shipping_city'])}',
            '{$con->real_escape_string($orderData['shipping_state'])}',
            '{$con->real_escape_string($orderData['shipping_pincode'])}',
            '{$con->real_escape_string($orderData['total_products'])}',
            '{$con->real_escape_string($orderData['subtotal'])}',
            '{$con->real_escape_string($orderData['gst'])}',
            '{$con->real_escape_string($orderData['total'])}',
            '{$con->real_escape_string($orderData['grandtotal'])}',
            '{$con->real_escape_string($coupon)}',
            '{$con->real_escape_string($discount)}',
            '{$con->real_escape_string($coupon_type)}',
            '{$con->real_escape_string($orderData['payment_mode'])}',
            '{$con->real_escape_string($orderData['payment_amount'])}',
            '{$con->real_escape_string($orderData['payment_reference'])}',
            '{$con->real_escape_string($orderData['payment_proof'])}',
            '{$con->real_escape_string($orderData['approval'])}',
            '{$con->real_escape_string($orderData['remarks'])}',
            '{$con->real_escape_string($orderData['status'])}',
            '{$con->real_escape_string($orderData['payment_id'])}',
            '{$con->real_escape_string($orderData['payment_date'])}',
            '{$con->real_escape_string($orderData['order_status'])}',
            '{$con->real_escape_string($orderData['payment_status'])}'
        )";
        
        error_log("Executing SQL: " . $sql);
        
        if ($con->query($sql)) {
            $order_id = $con->insert_id;
            
            // Fetch cart items for the user and insert into order_products
            $cartQuery = $con->prepare('SELECT 
                cart.user_id, 
                cart.product_id, 
                cart.quantity, 
                products.product_name, 
                products.featured_image,
                products.product_price as actual_price,
                products.discounted_price,
                products.slug,
                ornaments.name AS ornament_name
            FROM cart 
            INNER JOIN products ON cart.product_id = products.id 
            LEFT JOIN ornaments ON products.ornament_type = ornaments.id 
            WHERE cart.user_id = ?');

            $cartQuery->bind_param('i', $orderData['user_id']);
            $cartQuery->execute();
            $cartResult = $cartQuery->get_result();

            // Prepare order_products insertion
            $orderProductQuery = $con->prepare('INSERT INTO order_products (
                order_id, user_id, product_id, product_name, product_image, 
                quantity, product_actual_price, product_price, product_slug, product_type
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

            while ($cartRow = $cartResult->fetch_assoc()) {
                $orderProductQuery->bind_param('iisssiddss', 
                    $order_id,
                    $cartRow['user_id'],
                    $cartRow['product_id'],
                    $cartRow['product_name'],
                    $cartRow['featured_image'],
                    $cartRow['quantity'],
                    $cartRow['actual_price'],
                    $cartRow['discounted_price'],
                    $cartRow['slug'],
                    $cartRow['ornament_name']
                );
                
                if (!$orderProductQuery->execute()) {
                    throw new Exception("Failed to insert order product: " . $orderProductQuery->error);
                }
            }

            // Clear cart
            $clearCart = $con->prepare('DELETE FROM cart WHERE user_id = ?');
            $clearCart->bind_param('s', $orderData['user_id']);
            if (!$clearCart->execute()) {
                throw new Exception("Failed to clear cart: " . $clearCart->error);
            }

            $con->commit();
            $res['status'] = 1;
            $res['order_id'] = $orderData['order_id'];
        } else {
            throw new Exception("Failed to insert order: " . $con->error);
        }

    } catch (Exception $e) {
        if (isset($con)) {
            $con->rollback();
        }
        error_log("Error in PlaceOrder: " . $e->getMessage());
        $res['error'] = $e->getMessage();
    } finally {
        if (isset($cartQuery)) $cartQuery->close();
        if (isset($orderProductQuery)) $orderProductQuery->close();
        if (isset($clearCart)) $clearCart->close();
        if (isset($con)) $con->close();
    }

    return $res;
}
        public function getOrders() {
            $res = array();
            $res['status'] = 0;
            $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
            $query = $con->prepare('SELECT 
                                        id, user_id, billing_fullname, billing_email, billing_mobile, 
                                        billing_address1, billing_address2, billing_city, billing_state, billing_pincode, 
                                        shipping_fullname, shipping_email, shipping_mobile, shipping_address1, 
                                        shipping_address2, shipping_city, shipping_state, shipping_pincode, 
                                        total_products, subtotal, gst, total, grandtotal, coupon, discount, 
                                        coupon_type, payment_mode, payment_amount, payment_reference, payment_proof, 
                                        approval, order_status, remarks, status, created_at 
                                    FROM orders 
                                    ORDER BY id DESC');
            
            if ($query->execute()) {
                $query->bind_result(
                    $id, $user_id, $billing_fullname, $billing_email, $billing_mobile, 
                    $billing_address1, $billing_address2, $billing_city, $billing_state, $billing_pincode, 
                    $shipping_fullname, $shipping_email, $shipping_mobile, $shipping_address1, 
                    $shipping_address2, $shipping_city, $shipping_state, $shipping_pincode, 
                    $total_products, $subtotal, $gst, $total, $grandtotal, $coupon, $discount, 
                    $coupon_type, $payment_mode, $payment_amount, $payment_reference, $payment_proof, 
                    $approval, $order_status, $remarks, $status, $created_at
                );
                $i = 0;
                while ($query->fetch()) {
                    $res['status'] = 1;
                    $res['id'][$i] = $id;
                    $res['user_id'][$i] = $user_id;
                    $res['billing_fullname'][$i] = $billing_fullname;
                    $res['billing_email'][$i] = $billing_email;
                    $res['billing_mobile'][$i] = $billing_mobile;
                    $res['billing_address1'][$i] = $billing_address1;
                    $res['billing_address2'][$i] = $billing_address2;
                    $res['billing_city'][$i] = $billing_city;
                    $res['billing_state'][$i] = $billing_state;
                    $res['billing_pincode'][$i] = $billing_pincode;
                    $res['shipping_fullname'][$i] = $shipping_fullname;
                    $res['shipping_email'][$i] = $shipping_email;
                    $res['shipping_mobile'][$i] = $shipping_mobile;
                    $res['shipping_address1'][$i] = $shipping_address1;
                    $res['shipping_address2'][$i] = $shipping_address2;
                    $res['shipping_city'][$i] = $shipping_city;
                    $res['shipping_state'][$i] = $shipping_state;
                    $res['shipping_pincode'][$i] = $shipping_pincode;
                    $res['total_products'][$i] = $total_products;
                    $res['subtotal'][$i] = $subtotal;
                    $res['gst'][$i] = $gst;
                    $res['total'][$i] = $total;
                    $res['grandtotal'][$i] = $grandtotal;
                    $res['coupon'][$i] = $coupon;
                    $res['discount'][$i] = $discount;
                    $res['coupon_type'][$i] = $coupon_type;
                    $res['payment_mode'][$i] = $payment_mode;
                    $res['payment_amount'][$i] = $payment_amount;
                    $res['payment_reference'][$i] = $payment_reference;
                    $res['payment_proof'][$i] = $payment_proof;
                    $res['approval'][$i] = $approval;
                    $res['order_status'][$i] = $order_status;
                    $res['remarks'][$i] = $remarks;
                    $res['status_field'][$i] = $status; // Renamed to avoid conflict with the overall 'status' field
                    $res['created_at'][$i] = $created_at;

                    $i++;
                }
                $res['count'] = $i;
            } else {
                $err = 'Statement not Executed';
            }
            return $res;
        }


        public function getOrderProducts($order_id) {
            $res = array();
            $res['status'] = 0;
            $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
            $query = $con->prepare('SELECT 
                                        id, order_id, user_id, product_id, product_name, product_image, 
                                        quantity, product_weight, price_per_gram, product_actual_price, 
                                        product_price, product_slug, product_type, status, created_at 
                                    FROM order_products 
                                    WHERE order_id = ? 
                                    ORDER BY id DESC');
            
            $query->bind_param('i', $order_id);
            
            if ($query->execute()) {
                $query->bind_result(
                    $id, $order_id, $user_id, $product_id, $product_name, $product_image, 
                    $quantity, $product_weight, $price_per_gram, $product_actual_price, 
                    $product_price, $product_slug, $product_type, $status, $created_at
                );
                $i = 0;
                while ($query->fetch()) {
                    $res['status'] = 1;
                    $res['id'][$i] = $id;
                    $res['order_id'][$i] = $order_id;
                    $res['user_id'][$i] = $user_id;
                    $res['product_id'][$i] = $product_id;
                    $res['product_name'][$i] = $product_name;
                    $res['product_image'][$i] = $product_image;
                    $res['quantity'][$i] = $quantity;
                    $res['product_weight'][$i] = $product_weight;
                    $res['price_per_gram'][$i] = $price_per_gram;
                    $res['product_actual_price'][$i] = $product_actual_price;
                    $res['product_price'][$i] = $product_price;
                    $res['product_slug'][$i] = $product_slug;
                    $res['product_type'][$i] = $product_type;
                    $res['status_field'][$i] = $status;
                    $res['created_at'][$i] = $created_at;
                    $i++;
                }
                $res['count'] = $i;
            } else {
                $err = 'Statement not Executed';
            }
            return $res;
        }
public function submitContactForm($name, $email, $mobile, $message) {
    $result = ['status' => 0, 'message' => 'Error processing your request'];
    
    try {
        // Connect to database
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        if ($con->connect_error) {
            throw new Exception("Connection failed: " . $con->connect_error);
        }
        
        // Prepare and execute query
        $stmt = $con->prepare("INSERT INTO contact (name, email, mobile, message) VALUES (?, ?, ?, ?)");
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $con->error);
        }
        
        $stmt->bind_param("ssss", $name, $email, $mobile, $message);
        
        if ($stmt->execute()) {
            $result = [
                'status' => 1,
                'message' => 'Your message has been sent successfully. We will get back to you soon!'
            ];
        } else {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        
        $stmt->close();
        $con->close();
    } catch (Exception $e) {
        $result['message'] = "An error occurred: " . $e->getMessage();
        error_log("Contact form submission error: " . $e->getMessage());
    }
    
    return $result;
}

        public function addCustomizations($user_id, $image, $slug) {
            $res = array();
            $res['status'] = 0;
        
            // Establish database connection
            $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
            
            // Check connection
            if ($con->connect_error) {
                die("Connection failed: " . $con->connect_error);
            }
            
            // Begin transaction
            $con->begin_transaction();
        
            try {
                // Insert into users table
                $query = $con->prepare('INSERT INTO customizations ( user_id, image, reference) VALUES (?, ?, ?)');
                $query->bind_param('sss', $user_id, $image, $slug);
                
                if ($query->execute()) {
                    
                        // Commit transaction
                        $con->commit();
                        $res['status'] = 1;
                } else {
                    // Rollback transaction if users insertion fails
                    $con->rollback();
                    $err = 'Customizations statement not executed';
                    $res['error'] = $err;
                }
            } catch (Exception $e) {
                // Rollback transaction in case of error
                $con->rollback();
                $res['error'] = $e->getMessage();
            }
        
            // Close the connection
            $con->close();
        
            return $res;
        }




        public function getReviewByProductId($id) {
            $res = array();
            $res['status'] = 0;
            $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        

            $query = $con->prepare('
                SELECT 
                    r.id, r.user_id, u.name, r.product_id, r.rating, r.review, r.status, r.created_at 
                FROM 
                    ratings r
                INNER JOIN 
                    users u ON r.user_id = u.id
                WHERE 
                    r.product_id = ? and r.status = 1
                ORDER BY 
                    r.id DESC
            ');
        
            $query->bind_param('i', $id); // Bind the product ID parameter
        
            if ($query->execute()) {
                $query->bind_result($id, $user_id, $username, $product_id, $rating, $review, $status, $created_at);
                $i = 0;
                while ($query->fetch()) {
                    $res['status'] = 1;
                    $res['id'][$i] = $id;
                    $res['user_id'][$i] = $user_id;
                    $res['username'][$i] = $username; // Add username to the result
                    $res['product_id'][$i] = $product_id;
                    $res['rating'][$i] = $rating;
                    $res['review'][$i] = $review;
                    $res['statusval'][$i] = $status;
                    $res['created_at'][$i] = $created_at;
                    $i++;
                }
                $res['count'] = $i;
            } else {
                $res['error'] = 'Statement not executed';
            }
        
            return $res;
        }
        
        
    
        // public function AddContact($namecontact, $emailcontact, $subject, $message) {
        //     $res = array();
        //     $res['status'] = 0;
        
       
        //     $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
            
    
        //     if ($con->connect_error) {
        //         die("Connection failed: " . $con->connect_error);
        //     }

        //     $con->begin_transaction();
        
        //     try {

        //         $query = $con->prepare('INSERT INTO contact (name, email, subject, message) VALUES (?, ?, ?, ?)');
        //         $query->bind_param('ssss', $namecontact, $emailcontact, $subject, $message);
                
        //         if ($query->execute()) {
                 
        //             $con->commit();
        //             $res['status'] = 1;
        //         } else {
       
        //             $con->rollback();
        //             $err = 'Contact statement not executed: ' . $query->error;
        //             $res['error'] = $err;
        //             error_log($err); 
        //         }
        //     } catch (Exception $e) {
  
        //         $con->rollback();
        //         $res['error'] = $e->getMessage();
        //         error_log($e->getMessage());
        //     }
        

        //     $con->close();
        
        //     return $res;
        // }

        function AddContact($name, $email, $mobile, $message) {
            $res = ['status' => 0];
            
            // Database connection
            $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
            if ($con->connect_error) {
                return ['status' => 0, 'error' => 'Database connection failed: ' . $con->connect_error];
            }
        
            $con->begin_transaction();
            try {
                $query = $con->prepare('INSERT INTO contact (name, email, mobile, message) VALUES (?, ?, ?, ?)');
                $query->bind_param('ssss', $name, $email, $mobile, $message);
        
                if ($query->execute()) {
                    $con->commit();
                    return [
                        'status' => 1,
                        'contact_id' => $con->insert_id
                    ];
                } else {
                    $con->rollback();
                    return ['status' => 0, 'error' => 'Contact insert failed: ' . $query->error];
                }
            } catch (Exception $e) {
                $con->rollback();
                return ['status' => 0, 'error' => $e->getMessage()];
            } finally {
                $con->close();
            }
        }
        function getComments() {
            $res = array();
            $res['status'] = 0;
            $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
            $query = $con->prepare('
                SELECT id, blog_id, name, email, message, status, created_at 
                FROM comment_blog
            ');
        
            if ($query->execute()) {
                $query->bind_result($id, $blog_id, $name, $email, $message, $status, $created_at);
                $i = 0;
                while ($query->fetch()) {
                    $res['status'] = 1;
                    $res['id'][$i] = $id;
                    $res['blog_id'][$i] = $blog_id;
                    $res['name'][$i] = $name;
                    $res['email'][$i] = $email;
                    $res['message'][$i] = $message;
                    $res['statusval'][$i] = $status;
                    $res['created_at'][$i] = $created_at;
                    $i++;
                }
                $res['count'] = $i;
            } else {
                $res['error'] = 'Statement not Executed';
            }
        
            return $res;
        }
        function addComment($blog_id, $name, $email, $message, $status = 1) {
            $res = array();
            $res['status'] = 0;
        
            $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
            if ($con->connect_error) {
                die("Connection failed: " . $con->connect_error);
            }
        
            $con->begin_transaction();
        
            try {
                $query = $con->prepare('INSERT INTO comment_blog (blog_id, name, email, message, status) VALUES (?, ?, ?, ?, ?)');
                $query->bind_param('isssi', $blog_id, $name, $email, $message, $status);
        
                if ($query->execute()) {
                    $con->commit();
                    $res['status'] = 1;
                } else {
                    $con->rollback();
                    $res['error'] = 'Insert statement failed';
                }
            } catch (Exception $e) {
                $con->rollback();
                $res['error'] = $e->getMessage();
            }
        
            $con->close();
            return $res;
        }

public function hasUserPurchasedProduct($user_id, $product_id) {
    try {
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        if ($con->connect_error) {
            throw new Exception("Connection failed: " . $con->connect_error);
        }
        
        // Debug information
        error_log("Checking purchase for User ID: $user_id, Product ID: $product_id");
        
        // Check if user has purchased this product in the sales table
        $query = $con->prepare("
            SELECT COUNT(*) as count 
            FROM sales 
            WHERE buyer_id = ? 
            AND product_id = ? 
            AND payment_status = 'completed'
        ");
        
        if (!$query) {
            error_log("SQL Error in hasUserPurchasedProduct: " . $con->error);
            return false;
        }
        
        $query->bind_param("ii", $user_id, $product_id);
        $query->execute();
        $result_set = $query->get_result();
        $data = $result_set->fetch_assoc();
        
        $hasPurchased = ($data['count'] > 0);
        
        // Debug information
        error_log("Purchase check result: " . ($hasPurchased ? "User has purchased" : "User has not purchased"));
        
        $query->close();
        $con->close();
        
        return $hasPurchased;
    } catch (Exception $e) {
        error_log("Exception in hasUserPurchasedProduct: " . $e->getMessage());
        return false;
    }
}
public function getInsta() {
    $res = array();
    $res['status'] = 0;

    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

    if ($con->connect_error) {
        error_log("Connection failed: " . $con->connect_error);
        die("Connection failed: " . $con->connect_error);
    }

    $query = $con->prepare("SELECT id, image, url, status, created_at, update_at FROM insta ORDER BY created_at DESC");

    if (!$query) {
        error_log("Prepare failed: " . $con->error);
        return $res;
    }

    if ($query->execute()) {
        $query->bind_result($id, $image, $url, $status, $created_at, $update_at);
        $i = 0;
        while ($query->fetch()) {
            $res['status'] = 1;
            $res['id'][$i] = $id;
            $res['image'][$i] = $image;
            $res['url'][$i] = $url;
            $res['statusval'][$i] = $status;
            $res['created_at'][$i] = $created_at;
            $res['update_at'][$i] = $update_at;
            $i++;
        }
        $res['count'] = $i;
        error_log("Found " . $i . " insta entries");
    } else {
        error_log("Execute failed: " . $query->error);
    }

    $query->close();
    $con->close();

    return $res;
}

public function getFirstBrand() {
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

    $result = $con->query("SELECT * FROM brand WHERE id = 1 LIMIT 1");
    $data = [];

    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $data['status'] = 1;
    } else {
        $data['status'] = 0;
        $data['error'] = "No records found.";
    }

    $con->close();
    return $data;
}






/**
 * Record a sale in the sales table
 * 
 * @param array $saleData Sale data with product_id, seller_id, buyer_id, amount, etc.
 * @return array Status and message
 */
public function recordSale($saleData) {
    $result = array('status' => 0, 'message' => 'Failed to record sale');
    
    try {
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        if ($con->connect_error) {
            throw new Exception("Connection failed: " . $con->connect_error);
        }
        
        // Calculate commission and net amount
        $amount = floatval($saleData['amount']);
        $commission_rate = isset($saleData['commission_rate']) ? floatval($saleData['commission_rate']) : 10.00;
        $commission_amount = round(($amount * $commission_rate / 100), 2);
        $net_amount = round($amount - $commission_amount, 2);
        $payment_status = isset($saleData['payment_status']) ? $saleData['payment_status'] : 'completed';
        
        // Insert the sale record with complete SQL query
        $query = $con->prepare("
            INSERT INTO sales (
                product_id,
                seller_id,
                buyer_id,
                amount,
                commission_rate,
                commission_amount,
                net_amount,
                payment_status,
                created_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        
        if (!$query) {
            throw new Exception("Prepare failed: " . $con->error);
        }
        
        $query->bind_param(
            "iiidddds",
            $saleData['product_id'],
            $saleData['seller_id'],
            $saleData['buyer_id'],
            $amount,
            $commission_rate,
            $commission_amount,
            $net_amount,
            $payment_status
        );
        
        if ($query->execute()) {
            $sale_id = $con->insert_id;
            $result = array(
                'status' => 1,
                'message' => 'Sale recorded successfully',
                'sale_id' => $sale_id
            );
            error_log("Sale recorded successfully: ID=$sale_id, Amount=$amount, Net=$net_amount");
        } else {
            throw new Exception("Execute failed: " . $query->error);
        }
        
        $query->close();
        $con->close();
        
    } catch (Exception $e) {
        error_log("Error in recordSale: " . $e->getMessage());
        $result['message'] = $e->getMessage();
    }
    
    return $result;
}

public function AddTestimonial($name, $subject, $message, $rating, $image = '') {
    $res = array();
    $res['status'] = 0;
    
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    try {
        // Begin transaction
        $con->begin_transaction();

        $query = $con->prepare("INSERT INTO testimonials (name, subject, message, rating, image) VALUES (?, ?, ?, ?, ?)");
        $query->bind_param("sssis", $name, $subject, $message, $rating, $image);
        
        if ($query->execute()) {
            $con->commit();
            $res['status'] = 1;
        } else {
            $con->rollback();
            $res['error'] = 'Statement not executed: ' . $query->error;
        }
        
        $query->close();
    } catch (Exception $e) {
        $con->rollback();
        $res['error'] = $e->getMessage();
        error_log($e->getMessage());
    }

    $con->close();
    return $res;
}


public function getTestimonials() {
    $res = array();
    $res['status'] = 0;
    
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    if ($con->connect_error) {
        error_log("Connection failed: " . $con->connect_error);
        die("Connection failed: " . $con->connect_error);
    }

    $query = $con->prepare("SELECT id, name, subject, message, rating, image, status, created_at 
                           FROM testimonials 
                           ORDER BY created_at DESC");
    
    if (!$query) {
        error_log("Prepare failed: " . $con->error);
        return $res;
    }
    
    if ($query->execute()) {
        $query->bind_result($id, $name, $subject, $message, $rating, $image, $status, $created_at);
        $i = 0;
        while ($query->fetch()) {
            $res['status'] = 1;
            $res['id'][$i] = $id;
            $res['name'][$i] = $name;
            $res['subject'][$i] = $subject;
            $res['message'][$i] = $message;
            $res['rating'][$i] = $rating;
            $res['image'][$i] = $image;
            $res['statusval'][$i] = $status;
            $res['created_at'][$i] = $created_at;
            $i++;
        }
        $res['count'] = $i;
        error_log("Found " . $i . " testimonials");
    } else {
        error_log("Execute failed: " . $query->error);
    }

    $query->close();
    $con->close();
    
    return $res;
}

public function getFirstDod() {
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

    $result = $con->query("SELECT * FROM dod ORDER BY id ASC LIMIT 1");
    $data = [];

    if ($result && $result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $data['status'] = 1;
    } else {
        $data['status'] = 0;
        $data['error'] = "No records found.";
    }

    $con->close();
    return $data;
}

public function getHighlights() {
    $conn = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

    $sql = "SELECT * FROM highlights WHERE status = 1 ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = ['status' => 1, 'count' => $result->num_rows];
        $i = 0;
        while ($row = $result->fetch_assoc()) {
            $data['id'][$i] = $row['id'];
            $data['name'][$i] = $row['name'];
            $data['short_description'][$i] = $row['short_description'];
            $data['image'][$i] = $row['image'];
            $data['created_at'][$i] = $row['created_at'];
            $i++;
        }
        return $data;
    } else {
        return ['status' => 0];
    }
}
public function getAverageRating($product_id) {
    $res = array();
    $res['status'] = 0;
    $res['average_rating'] = 0; // Default average rating

    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());

    if ($con->connect_error) {
        error_log("Connection failed: " . $con->connect_error);
        die("Connection failed: " . $con->connect_error);
    }

    $query = $con->prepare("SELECT AVG(rating) as average_rating FROM ratings WHERE product_id = ? AND status = 1");

    if (!$query) {
        error_log("Prepare failed: " . $con->error);
        return $res;
    }

    $query->bind_param('i', $product_id);

    if ($query->execute()) {
        $query->bind_result($average_rating);
        if ($query->fetch()) {
            $res['status'] = 1;
            $res['average_rating'] = $average_rating ? round($average_rating, 1) : 0; // Round to 1 decimal place
        }
    } else {
        error_log("Execute failed: " . $query->error);
    }

    $query->close();
    $con->close();

    return $res;
}


public function searchProducts($query) {
    $res = array(
        'status' => 0,
        'message' => 'No products found',
        'count' => 0
    );
    
    try {
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        if ($con->connect_error) {
            throw new Exception("Connection failed: " . $con->connect_error);
        }
        
        // Sanitize and prepare search query
        $searchTerm = '%' . $con->real_escape_string($query) . '%';
        
        // Query to search in product name, description, short description
        $sql = "SELECT p.*, c.name as category_name, a.name as uploader_name, a.profile_img as uploader_profile_img
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN admin a ON p.uploader_id = a.id
                WHERE (p.product_name LIKE ? OR p.description LIKE ? OR p.short_description LIKE ?)
                AND p.status = 1
                ORDER BY p.product_name ASC
                LIMIT 10";
        
        $stmt = $con->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $con->error);
        }
        
        $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
        $stmt->execute();
        $queryResult = $stmt->get_result();
        
        if ($queryResult->num_rows > 0) {
            $res['status'] = 1;
            $res['count'] = $queryResult->num_rows;
            $res['total_count'] = $queryResult->num_rows; // Can be refined with another query for actual total count
            
            // Initialize arrays for all product data
            $res['id'] = [];
            $res['product_name'] = [];
            $res['featured_image'] = [];
            $res['product_price'] = [];
            $res['discounted_price'] = [];
            $res['short_description'] = [];
            $res['slug'] = [];
            
            while ($row = $queryResult->fetch_assoc()) {
                $res['id'][] = $row['id'];
                $res['product_name'][] = $row['product_name'];
                $res['featured_image'][] = $row['featured_image'];
                $res['product_price'][] = $row['product_price'];
                $res['discounted_price'][] = $row['discounted_price'];
                $res['short_description'][] = $row['short_description'];
                $res['slug'][] = $row['slug'];
            }
        }
        
        $stmt->close();
        $con->close();
    } catch (Exception $e) {
        $res['message'] = "Error: " . $e->getMessage();
        error_log("Search error: " . $e->getMessage());
    }
    
    return $res;
}

public function savePaymentDetails($data) {
    $res = array();
    $res['status'] = 0;

    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    if ($con->connect_error) {
        $res['error'] = "Connection failed: " . $con->connect_error;
        return $res;
    }

    try {
        // Start transaction
        $con->begin_transaction();

        // First update the orders table using the primary key id
        $updateOrderQuery = $con->prepare("
            UPDATE orders 
            SET 
                payment_status = 'paid',
                payment_id = ?,
                razorpay_order_id = ?,
                payment_date = NOW(),
                order_status = 'processing',
                payment_mode = 'Razorpay',
                payment_amount = ?,
                payment_reference = ?,
                updated_at = NOW()
            WHERE id = ?  -- Using primary key id to update the correct row
        ");
        
        if (!$updateOrderQuery) {
            throw new Exception("Failed to prepare order update query: " . $con->error);
        }

        // Bind parameters using the order's primary key id
        $updateOrderQuery->bind_param('ssssi', 
            $data['payment_id'],
            $data['razorpay_order_id'],
            $data['amount'],
            $data['payment_signature'],
            $data['order_id']  // This is now the primary key id of the orders table
        );

        // Rest of the function remains the same...
        if (!$updateOrderQuery->execute()) {
            throw new Exception("Failed to update order: " . $updateOrderQuery->error);
        }

        // Then insert into payments table using the same order id
        $paymentQuery = $con->prepare("
            INSERT INTO payments (
                order_id,  -- This will store the orders table primary key
                payment_id, 
                payment_signature, 
                amount, 
                status, 
                created_at
            ) VALUES (?, ?, ?, ?, ?, ?)
        ");

        if (!$paymentQuery) {
            throw new Exception("Failed to prepare payment query: " . $con->error);
        }

        $status = 'success';
        $created_at = date('Y-m-d H:i:s');

        $paymentQuery->bind_param(
            'sssdss',
            $data['order_id'],  // Using the same primary key id
            $data['payment_id'],
            $data['payment_signature'],
            $data['amount'],
            $status,
            $created_at
        );

        if (!$paymentQuery->execute()) {
            throw new Exception("Failed to save payment: " . $paymentQuery->error);
        }

        $con->commit();
        $res['status'] = 1;
        $res['message'] = 'Payment saved and order updated successfully';

    } catch (Exception $e) {
        $con->rollback();
        $res['error'] = $e->getMessage();
        error_log("Payment save error: " . $e->getMessage());
    } finally {
        if (isset($updateOrderQuery)) $updateOrderQuery->close();
        if (isset($paymentQuery)) $paymentQuery->close();
        $con->close();
    }

    return $res;
}

public function getOrderDetails($order_id) {
    $res = array();
    $res['status'] = 0;

    try {
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        if ($con->connect_error) {
            throw new Exception("Connection failed: " . $con->connect_error);
        }

        // Get order information with formatted date
        $orderQuery = $con->prepare("
            SELECT 
                o.*,
                DATE_FORMAT(o.created_at, '%d %M %Y') as formatted_date
            FROM orders o 
            WHERE o.id = ?
        ");
        
        $orderQuery->bind_param('i', $order_id);
        $orderQuery->execute();
        $orderResult = $orderQuery->get_result();
        
        if ($orderRow = $orderResult->fetch_assoc()) {
            $res['order'] = $orderRow;
            $res['status'] = 1;
            
            // Get ordered products from order_products table
            $productQuery = $con->prepare("
                SELECT 
                    op.*,
                    o.payment_status,
                    o.order_status
                FROM order_products op
                JOIN orders o ON op.order_id = o.id
                WHERE op.order_id = ?
                ORDER BY op.id ASC
            ");
            
            $productQuery->bind_param('i', $order_id);
            $productQuery->execute();
            $productResult = $productQuery->get_result();
            
            $products = array();
            $total_items = 0;
            
            while ($row = $productResult->fetch_assoc()) {
                $products[] = array(
                    'id' => $row['id'],
                    'product_id' => $row['product_id'],
                    'product_name' => $row['product_name'],
                    'product_image' => $row['product_image'],
                    'quantity' => $row['quantity'],
                    'product_type' => $row['product_type'],
                    'product_weight' => $row['product_weight'],
                    'price_per_gram' => $row['price_per_gram'],
                    'product_actual_price' => $row['product_actual_price'],
                    'product_price' => $row['product_price'],
                    'product_slug' => $row['product_slug'],
                    'payment_status' => $row['payment_status'],
                    'order_status' => $row['order_status']
                );
                
                $total_items += $row['quantity'];
            }
            
            $res['products'] = $products;
            $res['total_items'] = $total_items;
        }

    } catch (Exception $e) {
        $res['error'] = $e->getMessage();
    } finally {
        if (isset($orderQuery)) $orderQuery->close();
        if (isset($productQuery)) $productQuery->close();
        if (isset($con)) $con->close();
    }

    return $res;
}
public function getBlogBySlug($slug) {
    $res = array();
    $res['status'] = 0;
    $res['id'] = array();
    $res['username'] = array();
    $res['blog_heading'] = array();
    $res['blog_desc'] = array();
    $res['meta_title'] = array();
    $res['meta_keywords'] = array();
    $res['meta_description'] = array();
    $res['description'] = array();
    $res['featured_image'] = array();
    $res['slug_url'] = array();
    $res['status_value'] = array();
    $res['created_at'] = array();
    
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    if ($con->connect_error) {
        return $res;
    }
    
    $query = $con->prepare('SELECT id, username, blog_heading, blog_desc, meta_title, meta_keywords, meta_description, description, featured_image, slug_url, status, created_at FROM blogs WHERE slug_url = ? LIMIT 1');
    $query->bind_param('s', $slug);
    
    if ($query->execute()) {
        $query->store_result();
        
        if ($query->num_rows > 0) {
            $query->bind_result($id, $username, $blog_heading, $blog_desc, $meta_title, $meta_keywords, $meta_description, $description, $featured_image, $slug_url, $status, $created_at);
            
            if ($query->fetch()) {
                $res['id'][0] = $id;
                $res['username'][0] = $username;
                $res['blog_heading'][0] = $blog_heading;
                $res['blog_desc'][0] = $blog_desc;
                $res['meta_title'][0] = $meta_title;
                $res['meta_keywords'][0] = $meta_keywords;
                $res['meta_description'][0] = $meta_description;
                $res['description'][0] = $description;
                $res['featured_image'][0] = $featured_image;
                $res['slug_url'][0] = $slug_url;
                $res['status_value'][0] = $status;
                $res['created_at'][0] = $created_at;
                $res['status'] = 1;
            }
        }
    }
    
    $query->close();
    $con->close();
    return $res;
}

public function getNews() {
    $res = array();
    $res['status'] = 0;
    $res['id'] = array();
    $res['username'] = array();
    $res['newsheading'] = array();
    $res['newsdesc'] = array();
    $res['newslink'] = array();
    $res['meta_title'] = array();
    $res['meta_keywords'] = array();
    $res['meta_description'] = array();
    $res['featured_image'] = array();
    $res['status_value'] = array();
    $res['created_at'] = array();
    $res['count'] = 0;
    
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    if ($con->connect_error) {
        return $res;
    }
    
    $query = $con->prepare('SELECT id, username, newsheading, newsdesc, newslink, meta_title, meta_keywords, meta_description, featured_image, status, created_at FROM news ORDER BY id DESC');
    
    if (!$query) {
        return $res;
    }
    
    if ($query->execute()) {
        $query->store_result();
        $query->bind_result($id, $username, $newsheading, $newsdesc, $newslink, $meta_title, $meta_keywords, $meta_description, $featured_image, $status, $created_at);
        $i = 0;
        
        while ($query->fetch()) {
            $res['id'][$i] = $id;
            $res['username'][$i] = $username;
            $res['newsheading'][$i] = $newsheading;
            $res['newsdesc'][$i] = $newsdesc;
            $res['newslink'][$i] = $newslink;
            $res['meta_title'][$i] = $meta_title;
            $res['meta_keywords'][$i] = $meta_keywords;
            $res['meta_description'][$i] = $meta_description;
            $res['featured_image'][$i] = $featured_image;
            $res['status_value'][$i] = $status;
            $res['created_at'][$i] = $created_at;
            $i++;
        }
        
        $res['count'] = $i;
        $res['status'] = 1; // Set status to 1 when successful
    }
    
    $query->close();
    $con->close();
    return $res;
}

public function getShipmentByOrderId($orderId) {
    $res = array();
    $res['status'] = 0;
    $res['id'] = array();
    $res['order_id'] = array();
    $res['shiprocket_order_id'] = array();
    $res['shipment_id'] = array();
    $res['tracking_number'] = array();
    $res['courier_company'] = array();
    $res['awb_code'] = array();
    $res['payment_method'] = array();
    $res['shipping_cost'] = array();
    $res['customer_name'] = array();
    $res['customer_phone'] = array();
    $res['shipping_address'] = array();
    $res['shipping_city'] = array();
    $res['shipping_pincode'] = array();
    $res['created_at'] = array();
    $res['status_value'] = array();
    
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    if ($con->connect_error) {
        return $res;
    }
    
    $query = $con->prepare('SELECT id, order_id, shiprocket_order_id, shipment_id, tracking_number, 
                            courier_company, awb_code, payment_method, shipping_cost, 
                            customer_name, customer_phone, shipping_address, shipping_city, 
                            shipping_pincode, created_at, status 
                            FROM shipments WHERE order_id = ? LIMIT 1');
    
    if (!$query) {
        return $res;
    }
    
    $query->bind_param('s', $orderId);
    
    if ($query->execute()) {
        $query->store_result();
        
        if ($query->num_rows > 0) {
            $query->bind_result(
                $id, $order_id, $shiprocket_order_id, $shipment_id, $tracking_number, 
                $courier_company, $awb_code, $payment_method, $shipping_cost, 
                $customer_name, $customer_phone, $shipping_address, $shipping_city, 
                $shipping_pincode, $created_at, $status
            );
            
            if ($query->fetch()) {
                $res['id'][0] = $id;
                $res['order_id'][0] = $order_id;
                $res['shiprocket_order_id'][0] = $shiprocket_order_id;
                $res['shipment_id'][0] = $shipment_id;
                $res['tracking_number'][0] = $tracking_number;
                $res['courier_company'][0] = $courier_company;
                $res['awb_code'][0] = $awb_code;
                $res['payment_method'][0] = $payment_method;
                $res['shipping_cost'][0] = $shipping_cost;
                $res['customer_name'][0] = $customer_name;
                $res['customer_phone'][0] = $customer_phone;
                $res['shipping_address'][0] = $shipping_address;
                $res['shipping_city'][0] = $shipping_city;
                $res['shipping_pincode'][0] = $shipping_pincode;
                $res['created_at'][0] = $created_at;
                $res['status_value'][0] = $status;
                $res['status'] = 1;
            }
        }
    }
    
    $query->close();
    $con->close();
    return $res;
}






public function verifyOrderOwnership($order_id, $user_id) {
    $result = false;
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    if ($con->connect_error) {
        return $result;
    }
    
    $query = $con->prepare("SELECT id FROM orders WHERE id = ? AND user_id = ?");
    if (!$query) {
        return $result;
    }
    
    $query->bind_param('ii', $order_id, $user_id);
    
    if ($query->execute()) {
        $query->store_result();
        if ($query->num_rows > 0) {
            $result = true;
        }
    }
    
    $query->close();
    $con->close();
    return $result;
}

// Add these two complete function implementations to your logics class
public function updateOrderStatus($order_id, $status) {
    $result = false;
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    if ($con->connect_error) {
        error_log("Database connection failed: " . $con->connect_error);
        return $result;
    }
    
    $query = $con->prepare("UPDATE orders SET order_status = ? WHERE id = ?");
    if ($query) {
        $query->bind_param('si', $status, $order_id);
        $result = $query->execute();
        if (!$result) {
            error_log("Order status update error: " . $query->error);
        }
        $query->close();
    } else {
        error_log("Prepare failed for order status update: " . $con->error);
    }
    
    $con->close();
    return $result;
}

public function updateShipmentStatus($order_id, $status) {
    $result = false;
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    if ($con->connect_error) {
        error_log("Database connection failed: " . $con->connect_error);
        return $result;
    }
    
    $query = $con->prepare("UPDATE shipments SET status = ? WHERE order_id = ?");
    if ($query) {
        $query->bind_param('si', $status, $order_id);
        $result = $query->execute();
        if (!$result && $con->affected_rows == 0) {
            // If no rows affected, it might be because there's no shipment for this order
            error_log("No shipment found for order_id: " . $order_id);
        }
        $query->close();
    } else {
        error_log("Prepare failed for shipment status update: " . $con->error);
    }
    
    $con->close();
    return $result;
}
public function updateShipmentAWB($shipment_id, $awb_data) {
    $result = false;
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    if ($con->connect_error) {
        error_log("Database connection failed: " . $con->connect_error);
        return $result;
    }
    
    try {
        // First, get the order_id using shipment_id
        $get_order = $con->prepare("SELECT order_id FROM shipments WHERE shipment_id = ?");
        if (!$get_order) {
            error_log("Prepare failed: " . $con->error);
            return $result;
        }
        
        $get_order->bind_param('s', $shipment_id);
        $get_order->execute();
        $get_order->store_result();
        
        if ($get_order->num_rows > 0) {
            $get_order->bind_result($order_id);
            $get_order->fetch();
            $get_order->close();
            
            // Now update the shipment record
            $query = $con->prepare("UPDATE shipments SET 
                awb_code = ?,
                courier_company = ?,
                shipping_cost = ?,
                response_data = ?,
                status = 'AWB Generated',
                updated_at = NOW()
                WHERE order_id = ?");
                
            if ($query) {
                $query->bind_param('ssdss', 
                    $awb_data['awb_code'],
                    $awb_data['courier_company'],
                    $awb_data['shipping_cost'],
                    $awb_data['response_data'],
                    $order_id
                );
                
                $result = $query->execute();
                if (!$result) {
                    error_log("Execute failed: " . $query->error);
                }
                $query->close();
            } else {
                error_log("Prepare failed: " . $con->error);
            }
        }
    } catch (Exception $e) {
        error_log("Error updating AWB: " . $e->getMessage());
    }
    
    $con->close();
    return $result;
}






public function getOrderById($orderId) {
    $res = array();
    $res['status'] = 0;
    
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    if ($con->connect_error) {
        throw new Exception("Connection failed: " . $con->connect_error);
    }

    try {
        $query = $con->prepare("SELECT * FROM orders WHERE id = ?");
        $query->bind_param('i', $orderId);
        
        if ($query->execute()) {
            $result = $query->get_result();
            if ($row = $result->fetch_assoc()) {
                $res = array_merge($res, $row);
                $res['status'] = 1;
            }
        }

        $query->close();
    } catch (Exception $e) {
        error_log("Error getting order: " . $e->getMessage());
    } finally {
        $con->close();
    }
    
    return $res;
}

public function AddProject(
    $uploader_id,
    $category_id, 
    $subcategory_id, 
    $product_name, 
    $featured_image, 
    $short_description, 
    $description, 
    $youtube_url, 
    $project_files_zip, 
    $project_files_pdf, 
    $project_files_doc, 
    $product_price, 
    $discount_percentage, 
    $is_popular_collection, 
    $is_recommended
) {
    try {
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Generate slug from product name
        $slug = strtolower(str_replace(' ', '-', $product_name));
        
        // Calculate discounted price
        $discounted_price = $product_price - ($product_price * ($discount_percentage / 100));
        
        $query = $con->prepare("
            INSERT INTO projects (
                uploader_id, category_id, subcategory_id, product_name, 
                featured_image, short_description, description, youtube_url,
                project_files_zip, project_files_pdf, project_files_doc,
                product_price, discount_percentage, discounted_price,
                is_popular_collection, is_recommended, slug, created_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        
        $query->bind_param(
            "iiissssssssddiis",
            $uploader_id, $category_id, $subcategory_id, $product_name,
            $featured_image, $short_description, $description, $youtube_url,
            $project_files_zip, $project_files_pdf, $project_files_doc,
            $product_price, $discount_percentage, $discounted_price,
            $is_popular_collection, $is_recommended, $slug
        );
        
        $result = $query->execute();
        $con->close();
        return $result;
        
    } catch (Exception $e) {
        error_log("Error in AddProject: " . $e->getMessage());
        return false;
    }
}






/**
 * Get all projects/items uploaded by a specific user
 * 
 * @param int $user_id The user ID
 * @return array The user's projects/items
 */
public function getUserProjects($user_id) {
    $result = array(
        'status' => 0,
        'message' => 'No items found',
        'count' => 0,
        'data' => array()
    );
    
    try {
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        if ($con->connect_error) {
            return $result;
        }
        
        // First get the count of products
        $countQuery = $con->prepare("
            SELECT COUNT(*) as total
            FROM products
            WHERE uploader_id = ? AND status = 1
        ");
        
        if (!$countQuery) {
            error_log("SQL Error in count query: " . $con->error);
            return $result;
        }
        
        $countQuery->bind_param("i", $user_id);
        $countQuery->execute();
        $countResult = $countQuery->get_result();
        
        if ($row = $countResult->fetch_assoc()) {
            $result['count'] = (int)$row['total'];
        }
        
        $countQuery->close();
        
        // If we have products, fetch them
        if ($result['count'] > 0) {
            // Get the products with all needed fields
            $query = $con->prepare("
                SELECT id, product_name, featured_image, product_price, 
                       discount_percentage, discounted_price, short_description,
                       description, slug, status, created_at, updated_at,
                       project_files_zip, project_link, youtube_url
                FROM products 
                WHERE uploader_id = ? AND status = 1
                ORDER BY created_at DESC
            ");
            
            if (!$query) {
                error_log("SQL Error in products query: " . $con->error);
                return $result;
            }
            
            $query->bind_param("i", $user_id);
            
            if ($query->execute()) {
                $queryResult = $query->get_result();
                
                while ($product = $queryResult->fetch_assoc()) {
                    // Calculate discounted price if it's NULL
                    if ($product['discounted_price'] === null || $product['discounted_price'] == 0) {
                        $product['discounted_price'] = $product['product_price'] - 
                            ($product['product_price'] * ($product['discount_percentage'] / 100));
                    }
                    
                    $result['data'][] = $product;
                }
                
                if (!empty($result['data'])) {
                    $result['status'] = 1;
                    $result['message'] = 'Products found';
                }
            } else {
                error_log("Execute failed: " . $query->error);
            }
            
            $query->close();
        }
        
        $con->close();
        
    } catch (Exception $e) {
        error_log("Exception in getUserProjects: " . $e->getMessage());
    }
    
    return $result;
}

// Update the toggleFollow method in logics.class.php

public function toggleFollow($follower_id, $following_id) {
    $res = array('status' => 0);
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    try {
        // Check if already following
        $checkQuery = $con->prepare("SELECT id FROM user_follows WHERE follower_id = ? AND following_id = ?");
        $checkQuery->bind_param('ii', $follower_id, $following_id);
        $checkQuery->execute();
        $result = $checkQuery->get_result();
        
        if ($result->num_rows > 0) {
            // Already following, so unfollow
            $row = $result->fetch_assoc();
            $followId = $row['id'];
            
            $deleteQuery = $con->prepare("DELETE FROM user_follows WHERE id = ?");
            $deleteQuery->bind_param('i', $followId);
            
            if ($deleteQuery->execute()) {
                $res['status'] = 1;
                $res['action'] = 'unfollowed';
                $res['message'] = 'User unfollowed successfully';
            } else {
                $res['error'] = 'Failed to unfollow user: ' . $deleteQuery->error;
            }
            
            $deleteQuery->close();
        } else {
            // Not following, so follow
            $insertQuery = $con->prepare("INSERT INTO user_follows (follower_id, following_id, created_at) VALUES (?, ?, NOW())");
            $insertQuery->bind_param('ii', $follower_id, $following_id);
            
            if ($insertQuery->execute()) {
                $res['status'] = 1;
                $res['action'] = 'followed';
                $res['message'] = 'User followed successfully';
            } else {
                $res['error'] = 'Failed to follow user: ' . $insertQuery->error;
            }
            
            $insertQuery->close();
        }
        
        $checkQuery->close();
    } catch (Exception $e) {
        $res['error'] = $e->getMessage();
    }
    
    $con->close();
    return $res;
}

public function isFollowing($follower_id, $following_id) {
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    try {
        $query = $con->prepare("SELECT COUNT(*) as count FROM user_follows WHERE follower_id = ? AND following_id = ?");
        $query->bind_param('ii', $follower_id, $following_id);
        
        if ($query->execute()) {
            $result = $query->get_result();
            $row = $result->fetch_assoc();
            $query->close();
            $con->close();
            return ($row['count'] > 0);
        }
    } catch (Exception $e) {
        error_log("Error in isFollowing: " . $e->getMessage());
    }
    
    if (isset($query)) $query->close();
    $con->close();
    return false;
}
public function getUserSales($user_id, $type = 'seller') {
    $res = array();
    $res['status'] = 0;
    $res['data'] = array();
    
    try {
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        if ($con->connect_error) {
            throw new Exception("Connection failed: " . $con->connect_error);
        }
        
        // SQL query changes based on whether we're looking for sales or purchases
        if ($type == 'seller') {
            $sql = "SELECT 
                    s.id, 
                    s.product_id, 
                    s.buyer_id, 
                    s.amount, 
                    s.payment_status, 
                    s.created_at,
                    p.product_name, 
                    p.featured_image,
                    a.name AS buyer_name
                FROM 
                    sales s
                JOIN 
                    products p ON s.product_id = p.id
                JOIN 
                    admin a ON s.buyer_id = a.id
                WHERE 
                    s.seller_id = ?
                ORDER BY 
                    s.created_at DESC
                LIMIT 10";
        } else {
            $sql = "SELECT 
                    s.id, 
                    s.product_id, 
                    s.seller_id, 
                    s.amount, 
                    s.payment_status, 
                    s.created_at,
                    p.product_name, 
                    p.featured_image,
                    a.name AS seller_name
                FROM 
                    sales s
                JOIN 
                    products p ON s.product_id = p.id
                JOIN 
                    admin a ON s.seller_id = a.id
                WHERE 
                    s.buyer_id = ?
                ORDER BY 
                    s.created_at DESC
                LIMIT 10";
        }
        
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $user_id);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $res['data'][] = $row;
                }
                $res['status'] = 1;
            }
        }
        
        $stmt->close();
        $con->close();
        
    } catch (Exception $e) {
        error_log("Error in getUserSales: " . $e->getMessage());
    }
    
    return $res;
}

public function getUserEarnings($user_id) {
    try {
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $sql = "SELECT 
                SUM(commission_amount) as total_earnings,
                SUM(CASE WHEN payment_status = 'pending' THEN commission_amount ELSE 0 END) as pending_earnings,
                SUM(CASE WHEN payment_status = 'paid' THEN commission_amount ELSE 0 END) as paid_earnings
                FROM user_project_sales 
                WHERE seller_id = ?";
        
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        
        $con->close();
        return $result;
        
    } catch (Exception $e) {
        error_log("Error in getUserEarnings: " . $e->getMessage());
        return array(
            'total_earnings' => 0,
            'pending_earnings' => 0,
            'paid_earnings' => 0
        );
    }
}

public function createWithdrawalRequest($user_id, $amount) {
    try {
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        // Check if user has enough pending earnings
        $earnings = $this->getUserEarnings($user_id);
        if ($earnings['pending_earnings'] < $amount) {
            $con->close();
            return array('status' => 0, 'message' => 'Insufficient pending earnings');
        }
        
        $sql = "INSERT INTO withdrawal_requests (user_id, amount, request_date, status) 
                VALUES (?, ?, NOW(), 'pending')";
        
        $stmt = $con->prepare($sql);
        $stmt->bind_param("id", $user_id, $amount);
        $result = $stmt->execute();
        
        $con->close();
        return array(
            'status' => $result ? 1 : 0,
            'message' => $result ? 'Withdrawal request submitted successfully' : 'Error submitting withdrawal request'
        );
        
    } catch (Exception $e) {
        error_log("Error in createWithdrawalRequest: " . $e->getMessage());
        return array('status' => 0, 'message' => 'Error submitting withdrawal request');
    }
}

public function getWithdrawalRequests($user_id) {
    try {
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $sql = "SELECT * FROM withdrawal_requests WHERE user_id = ? ORDER BY request_date DESC";
        
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $requests = array();
        while ($row = $result->fetch_assoc()) {
            $requests[] = $row;
        }
        
        $con->close();
        return $requests;
        
    } catch (Exception $e) {
        error_log("Error in getWithdrawalRequests: " . $e->getMessage());
        return array();
    }
}

public function addProductReview($product_id, $reviewer_name, $reviewer_email, $rating, $review_title, $review_content) {
    try {
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        $sql = "INSERT INTO ratings (product_id, reviewer_name, reviewer_email, rating, review_title, review_content, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        
        $stmt = $con->prepare($sql);
        $stmt->bind_param("issdss", $product_id, $reviewer_name, $reviewer_email, $rating, $review_title, $review_content);
        $result = $stmt->execute();
        
        $con->close();
        return $result;
        
    } catch (Exception $e) {
        error_log("Error in addProductReview: " . $e->getMessage());
        return false;
    }
}

private function ensureRatingsTableExists($con) {
    $createTableQuery = "
        CREATE TABLE IF NOT EXISTS ratings (
            id INT PRIMARY KEY AUTO_INCREMENT,
            product_id INT NOT NULL,
            user_id INT NOT NULL,
            rating DECIMAL(2,1) NOT NULL,
            review_title VARCHAR(255) NOT NULL,
            review_content TEXT NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            status TINYINT(1) DEFAULT 1,
            FOREIGN KEY (product_id) REFERENCES projects(id) ON DELETE CASCADE,
            FOREIGN KEY (user_id) REFERENCES admin(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";
    
    if (!$con->query($createTableQuery)) {
        error_log("Error creating ratings table: " . $con->error);
    }
}


// Add or update these methods to the logics class



public function addReview($data) {
    $res = array('status' => 0, 'message' => 'Failed to add review');
    
    try {
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        if ($con->connect_error) {
            throw new Exception("Connection failed: " . $con->connect_error);
        }
        
        // Check if user already reviewed this product
        $checkQuery = $con->prepare("SELECT id FROM reviews WHERE product_id = ? AND user_id = ?");
        $checkQuery->bind_param("ii", $data['product_id'], $data['user_id']);
        $checkQuery->execute();
        $checkResult = $checkQuery->get_result();
        
        if ($checkResult->num_rows > 0) {
            // User already reviewed, update the existing review
            $row = $checkResult->fetch_assoc();
            $reviewId = $row['id'];
            
            $updateQuery = $con->prepare("
                UPDATE reviews 
                SET rating = ?, review_title = ?, review_content = ?, updated_at = NOW() 
                WHERE id = ?
            ");
            
            $updateQuery->bind_param(
                "dssi", 
                $data['rating'], 
                $data['review_title'], 
                $data['review_content'], 
                $reviewId
            );
            
            if ($updateQuery->execute()) {
                $res['status'] = 1;
                $res['message'] = 'Your review has been updated';
                
                // Get the updated review
                $res['review'] = $this->getSingleReview($reviewId, $con);
                
                // Update product rating
                $this->updateProductRating($data['product_id'], $con);
            } else {
                $res['message'] = 'Failed to update review: ' . $updateQuery->error;
            }
            
            $updateQuery->close();
        } else {
            // Insert new review
            $insertQuery = $con->prepare("
                INSERT INTO reviews (product_id, user_id, rating, review_title, review_content) 
                VALUES (?, ?, ?, ?, ?)
            ");
            
            $insertQuery->bind_param(
                "iidss", 
                $data['product_id'], 
                $data['user_id'], 
                $data['rating'], 
                $data['review_title'], 
                $data['review_content']
            );
            
            if ($insertQuery->execute()) {
                $reviewId = $con->insert_id;
                $res['status'] = 1;
                $res['message'] = 'Your review has been submitted';
                
                // Get the new review
                $res['review'] = $this->getSingleReview($reviewId, $con);
                
                // Update product rating
                $this->updateProductRating($data['product_id'], $con);
            } else {
                $res['message'] = 'Failed to submit review: ' . $insertQuery->error;
            }
            
            $insertQuery->close();
        }
        
        $checkQuery->close();
        
        if ($res['status'] == 1) {
            // Also update the user's overall rating
            $this->updateUserRating($data['user_id']);
        }
        
        $con->close();
        
    } catch (Exception $e) {
        $res['message'] = 'Error: ' . $e->getMessage();
        error_log("Error in addReview: " . $e->getMessage());
    }
    
    return $res;
}




private function updateProductRating($productId, $con = null) {
    $closeConnection = false;
    
    if ($con === null) {
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        $closeConnection = true;
    }
    
    // First, check if the rating column exists in the products table
    $checkColumnQuery = "SHOW COLUMNS FROM products LIKE 'rating'";
    $columnResult = $con->query($checkColumnQuery);
    
    // If rating column doesn't exist, add it
    if ($columnResult->num_rows == 0) {
        $alterTableQuery = "ALTER TABLE products ADD COLUMN rating DECIMAL(2,1) DEFAULT 0";
        $con->query($alterTableQuery);
    }
    
    // Now update the rating
    $query = $con->prepare("
        UPDATE products SET rating = (
            SELECT COALESCE(AVG(r.rating), 0)
            FROM reviews r
            WHERE r.product_id = ? AND r.status = 1
        )
        WHERE id = ?
    ");
    
    $query->bind_param("ii", $productId, $productId);
    $query->execute();
    $query->close();
    
    if ($closeConnection) {
        $con->close();
    }
}


private function timeAgo($timestamp) {
    $datetime = new DateTime($timestamp);
    $now = new DateTime();
    $interval = $now->diff($datetime);
    
    if ($interval->y >= 1) return $interval->y . " year" . ($interval->y > 1 ? "s" : "") . " ago";
    if ($interval->m >= 1) return $interval->m . " month" . ($interval->m > 1 ? "s" : "") . " ago";
    if ($interval->d >= 1) return $interval->d . " day" . ($interval->d > 1 ? "s" : "") . " ago";
    if ($interval->h >= 1) return $interval->h . " hour" . ($interval->h > 1 ? "s" : "") . " ago";
    if ($interval->i >= 1) return $interval->i . " minute" . ($interval->i > 1 ? "s" : "") . " ago";
    return "just now";
}

// Add this helper function to check if a user has already reviewed a product
public function hasUserReviewed($userId, $productId) {
    $result = false;
    
    try {
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        if ($con->connect_error) {
            error_log("Connection failed: " . $con->connect_error);
            return $result;
        }
        
        $query = $con->prepare("
            SELECT id, rating, review_title, review_content 
            FROM reviews 
            WHERE product_id = ? AND user_id = ?
        ");
        
        $query->bind_param("ii", $productId, $userId);
        $query->execute();
        $queryResult = $query->get_result();
        
        if ($queryResult->num_rows > 0) {
            $result = $queryResult->fetch_assoc();
        }
        
        $query->close();
        $con->close();
        
    } catch (Exception $e) {
        error_log("Error in hasUserReviewed: " . $e->getMessage());
    }
    
    return $result;
}























// Find the methods that might be referencing the 'users' table and correct them
// Here's the method that likely needs to be fixed:

private function updateUserRating($userId) {
    $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
    
    try {
        // Check if connection was successful
        if ($con->connect_error) {
            return;
        }
        
        // Changed 'users' to 'admin' in this query
        $query = $con->prepare("
            UPDATE admin u
            SET u.rating = (
                SELECT COALESCE(AVG(r.rating), 0)
                FROM reviews r
                JOIN products p ON r.product_id = p.id
                WHERE p.uploader_id = ? AND r.status = 1
            )
            WHERE u.id = ?
        ");
        
        if (!$query) {
            // Handle prepare error
            return;
        }
        
        $query->bind_param("ii", $userId, $userId);
        $query->execute();
        $query->close();
    } catch (Exception $e) {
        // Silently handle exception
    }
    
    $con->close();
}

// Also check if there are any other methods referencing 'users' table
// For example, when getting user data:

public function getUserById($userId) {
    $result = [];
    
    try {
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        if ($con->connect_error) {
            return $result;
        }
        
        // Changed 'users' to 'admin' in this query if it exists
        $query = $con->prepare("
            SELECT * FROM admin WHERE id = ?
        ");
        
        if (!$query) {
            return $result;
        }
        
        $query->bind_param("i", $userId);
        $query->execute();
        $queryResult = $query->get_result();
        
        if ($queryResult->num_rows > 0) {
            $result = $queryResult->fetch_assoc();
        }
        
        $query->close();
        $con->close();
    } catch (Exception $e) {
        // Silently handle exception
    }
    
    return $result;
}

// And one more check for references to users table in the review methods:
public function getMoreReviews($productId, $offset = 0) {
    $res = array(
        'status' => 0,
        'message' => 'No reviews found',
        'reviews' => []
    );
    
    try {
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        if ($con->connect_error) {
            return $res;
        }
        
        // Make sure this query uses 'admin' instead of 'users'
        $query = $con->prepare("
            SELECT r.id, r.rating, r.review_title, r.review_content, r.created_at,
                   a.id as user_id, a.name as user_name, a.profile_img
            FROM reviews r
            JOIN admin a ON r.user_id = a.id
            WHERE r.product_id = ? AND r.status = 1
            ORDER BY r.created_at DESC
            LIMIT 10 OFFSET ?
        ");
        
        if (!$query) {
            return $res;
        }
        
        $query->bind_param("ii", $productId, $offset);
        
        if ($query->execute()) {
            $result = $query->get_result();
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $row['created_at_formatted'] = $this->timeAgo($row['created_at']);
                    $res['reviews'][] = $row;
                }
                
                $res['status'] = 1;
                $res['message'] = 'Reviews loaded successfully';
            }
        }
        
        $query->close();
        $con->close();
    } catch (Exception $e) {
        // Silently handle exception
    }
    
    return $res;
}

// Also check the getSingleReview method:
private function getSingleReview($reviewId, $con) {
    $review = null;
    
    try {
        $query = $con->prepare("
            SELECT r.id, r.rating, r.review_title, r.review_content, r.created_at,
                   a.id as user_id, a.name as user_name, a.profile_img
            FROM reviews r
            JOIN admin a ON r.user_id = a.id
            WHERE r.id = ?
        ");
        
        if (!$query) {
            return $review;
        }
        
        $query->bind_param("i", $reviewId);
        $query->execute();
        $result = $query->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $row['created_at_formatted'] = $this->timeAgo($row['created_at']);
            $review = $row;
        }
        
        $query->close();
    } catch (Exception $e) {
        // Silently handle exception
    }
    
    return $review;
}

// And finally check getProductRatings:
public function getProductRatings($productId) {
    $res = array(
        'average' => 0,
        'total_reviews' => 0,
        'breakdown' => [
            '5' => 0,
            '4' => 0,
            '3' => 0,
            '2' => 0,
            '1' => 0
        ],
        'reviews' => []
    );
    
    try {
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        if ($con->connect_error) {
            return $res;
        }
        
        // Get average rating and count
        $avgQuery = $con->prepare("
            SELECT AVG(rating) as avg_rating, COUNT(*) as total
            FROM reviews 
            WHERE product_id = ? AND status = 1
        ");
        
        if (!$avgQuery) {
            return $res;
        }
        
        $avgQuery->bind_param("i", $productId);
        $avgQuery->execute();
        $avgResult = $avgQuery->get_result();
        
        if ($row = $avgResult->fetch_assoc()) {
            $res['average'] = $row['avg_rating'] ? round($row['avg_rating'], 1) : 0;
            $res['total_reviews'] = (int)$row['total'];
        }
        
        $avgQuery->close();
        
        // Get rating breakdown
        if ($res['total_reviews'] > 0) {
            $breakdownQuery = $con->prepare("
                SELECT FLOOR(rating) as stars, COUNT(*) as count
                FROM reviews 
                WHERE product_id = ? AND status = 1
                GROUP BY FLOOR(rating)
            ");
            
            if (!$breakdownQuery) {
                return $res;
            }
            
            $breakdownQuery->bind_param("i", $productId);
            $breakdownQuery->execute();
            $breakdownResult = $breakdownQuery->get_result();
            
            while ($row = $breakdownResult->fetch_assoc()) {
                $stars = $row['stars'];
                if ($stars < 1) $stars = 1;
                if ($stars > 5) $stars = 5;
                $res['breakdown']["$stars"] = (int)$row['count'];
            }
            
            $breakdownQuery->close();
        }
        
        // Get reviews with user info - use admin table instead of users
        $reviewsQuery = $con->prepare("
            SELECT r.id, r.rating, r.review_title, r.review_content, r.created_at,
                   a.id as user_id, a.name as user_name, a.profile_img
            FROM reviews r
            JOIN admin a ON r.user_id = a.id
            WHERE r.product_id = ? AND r.status = 1
            ORDER BY r.created_at DESC
            LIMIT 10
        ");
        
        if (!$reviewsQuery) {
            return $res;
        }
        
        $reviewsQuery->bind_param("i", $productId);
        $reviewsQuery->execute();
        $reviewsResult = $reviewsQuery->get_result();
        
        while ($row = $reviewsResult->fetch_assoc()) {
            $row['created_at_formatted'] = $this->timeAgo($row['created_at']);
            $res['reviews'][] = $row;
        }
        
        $reviewsQuery->close();
        $con->close();
    } catch (Exception $e) {
        // Silently handle exception
    }
    
    return $res;
}


// Add these methods to your logics class

/**
 * Get all reviews for a user's products
 * 
 * @param int $user_id The user ID
 * @return array The reviews data
 */
public function getUserProductReviews($user_id) {
    $reviews = array();
    
    try {
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        if ($con->connect_error) {
            error_log("Connection failed: " . $con->connect_error);
            return $reviews;
        }
        
        // Get all reviews for products uploaded by this user
        $query = $con->prepare("
            SELECT r.id, r.rating, r.review_title, r.review_content, r.created_at,
                   a.id AS reviewer_id, a.name AS reviewer_name, a.profile_img AS reviewer_img,
                   p.id AS product_id, p.product_name, p.slug AS product_slug
            FROM reviews r
            JOIN products p ON r.product_id = p.id
            JOIN admin a ON r.user_id = a.id
            WHERE p.uploader_id = ? AND r.status = 1
            ORDER BY r.created_at DESC
        ");
        
        if (!$query) {
            error_log("Prepare failed: " . $con->error);
            return $reviews;
        }
        
        $query->bind_param("i", $user_id);
        
        if ($query->execute()) {
            $result = $query->get_result();
            
            while ($row = $result->fetch_assoc()) {
                $reviews[] = $row;
            }
        } else {
            error_log("Execute failed: " . $query->error);
        }
        
        $query->close();
        $con->close();
        
    } catch (Exception $e) {
        error_log("Error in getUserProductReviews: " . $e->getMessage());
    }
    
    return $reviews;
}

/**
 * Calculate the average rating for a user's products
 * 
 * @param int $user_id The user ID
 * @return float The average rating
 */
public function getUserAverageRating($user_id) {
    $average = 0;
    
    try {
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        if ($con->connect_error) {
            error_log("Connection failed: " . $con->connect_error);
            return $average;
        }
        
        // Calculate average rating for all products
        $query = $con->prepare("
            SELECT AVG(r.rating) AS average_rating
            FROM reviews r
            JOIN products p ON r.product_id = p.id
            WHERE p.uploader_id = ? AND r.status = 1
        ");
        
        if (!$query) {
            error_log("Prepare failed: " . $con->error);
            return $average;
        }
        
        $query->bind_param("i", $user_id);
        
        if ($query->execute()) {
            $result = $query->get_result();
            $row = $result->fetch_assoc();
            
            if ($row && isset($row['average_rating'])) {
                $average = round($row['average_rating'], 1);
            }
        } else {
            error_log("Execute failed: " . $query->error);
        }
        
        $query->close();
        $con->close();
        
    } catch (Exception $e) {
        error_log("Error in getUserAverageRating: " . $e->getMessage());
    }
    
    return $average;
}

public function getOrderItems($order_id) {
    $res = array(
        'status' => 0,
        'count' => 0,
        'id' => array(),
        'product_id' => array(),
        'product_name' => array(),
        'file_path' => array(),
        'file_name' => array(),
        'quantity' => array(),
        'price' => array()
    );
    
    try {
        $con = new mysqli($this->hostName(), $this->userName(), $this->password(), $this->dbName());
        
        if ($con->connect_error) {
            throw new Exception("Connection failed: " . $con->connect_error);
        }
        
        // Get order items with product details
        $query = $con->prepare("
            SELECT oi.*, p.project_files_zip, p.product_name, p.id as product_id
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = ?
        ");
        
        if (!$query) {
            throw new Exception("Prepare failed: " . $con->error);
        }
        
        $query->bind_param("i", $order_id);
        
        if ($query->execute()) {
            $result = $query->get_result();
            $i = 0;
            
            while ($row = $result->fetch_assoc()) {
                $res['status'] = 1;
                $res['id'][$i] = $row['id'];
                $res['product_id'][$i] = $row['product_id'];
                $res['product_name'][$i] = $row['product_name'];
                $res['file_path'][$i] = $row['project_files_zip'];
                $res['file_name'][$i] = basename($row['project_files_zip']);
                $res['quantity'][$i] = isset($row['quantity']) ? (int)$row['quantity'] : 1;
                $res['price'][$i] = isset($row['price']) ? (float)$row['price'] : 0.00;
                $i++;
            }
            
            $res['count'] = $i;
        } else {
            throw new Exception("Execute failed: " . $query->error);
        }
        
        $query->close();
        $con->close();
        
    } catch (Exception $e) {
        error_log("Error in getOrderItems: " . $e->getMessage());
        $res['error'] = $e->getMessage();
    }
    
    return $res;
}
}

?>