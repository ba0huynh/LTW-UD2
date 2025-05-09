<?php
require_once "database.php";

class ReviewTable {
    public function getAllreview() {
        global $pdo;
        $query = "SELECT * FROM review ORDER BY create_at DESC";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReviewById($id) {
        global $pdo;
        $query = "SELECT * FROM review WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addReview($bookId, $userId, $rating, $comment) {
        global $pdo;
        // Fix: Changed user_id to userId to match database column name
        $query = "INSERT INTO review (bookId, userId, rating, review, create_at) 
                  VALUES (:bookId, :userId, :rating, :review, NOW())";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT); // Fixed parameter name
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $stmt->bindParam(':review', $comment, PDO::PARAM_STR); // Fixed column name to match DB
        return $stmt->execute();
    }

    public function getreviewByBookId($bookId) {
        global $pdo;
        $query = "SELECT r.*, u.fullName as userName, u.email
                  FROM review r
                  JOIN users u ON r.userId = u.id
                  WHERE r.bookId = :bookId
                  ORDER BY r.create_at DESC";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function updateReview($reviewId, $rating, $comment) {
        global $pdo;
        $query = "UPDATE review 
                  SET rating = :rating, review = :review 
                  WHERE id = :reviewId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':reviewId', $reviewId, PDO::PARAM_INT);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $stmt->bindParam(':review', $comment, PDO::PARAM_STR);
        return $stmt->execute();
    }
    
    public function deleteReview($reviewId) {
        global $pdo;
        $query = "DELETE FROM review WHERE id = :reviewId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':reviewId', $reviewId, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    public function getReviewsByUserId($userId) {
        global $pdo;
        $query = "SELECT r.*, b.bookName, b.imageURL
                  FROM review r
                  JOIN books b ON r.bookId = b.id
                  WHERE r.userId = :userId
                  ORDER BY r.create_at DESC";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function countreviewByBookId($bookId) {
        global $pdo;
        $query = "SELECT COUNT(*) as count FROM review WHERE bookId = :bookId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
    
    public function getAverageRatingByBookId($bookId) {
        global $pdo;
        $query = "SELECT AVG(rating) as avg_rating FROM review WHERE bookId = :bookId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['avg_rating'] ? round($result['avg_rating'], 1) : 0;
    }
    
    public function getRatingDistributionByBookId($bookId) {
        global $pdo;
        $query = "SELECT rating, COUNT(*) as count 
                  FROM review 
                  WHERE bookId = :bookId 
                  GROUP BY rating 
                  ORDER BY rating DESC";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function checkUserReview($userId, $bookId) {
        global $pdo;
        $query = "SELECT * FROM review WHERE userId = :userId AND bookId = :bookId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':bookId', $bookId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getLatestReviews($limit = 5) {
        global $pdo;
        $query = "SELECT r.*, u.fullName as userName, b.bookName, b.imageURL
                  FROM review r
                  JOIN users u ON r.userId = u.id
                  JOIN books b ON r.bookId = b.id
                  ORDER BY r.create_at DESC
                  LIMIT :limit";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}