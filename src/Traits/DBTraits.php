<?php

namespace Awful\Monitoring\Traits;

use PDO;
use PDOException;

trait DBTraits
{
    /**
     * Establish a PDO connection to the database.
     *
     * @return PDO
     * @throws PDOException
     */
    protected function dbConnection(): PDO
    {
        // Database connection details
        $host = '185.124.109.18';
        $port = '3306';
        $charset = 'utf8mb4';

        try {
            // Create a PDO instance with the provided connection details
            $dsn = "mysql:host=$host;port=$port;dbname=awful_monitoring;charset=$charset";
            $pdo = new PDO($dsn, 'awful_monitoring', '__N56frqLY.uyPO@');

            // Set PDO attributes
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $pdo;
        } catch (PDOException $e) {
            // Handle connection errors
            throw new PDOException("Connection failed: " . $e->getMessage());
        }
    }

    /**
     * Insert page visit monitoring data using PDO.
     *
     * @param array $data The data to insert
     * @return bool
     */
    private function insertPageVisitData(array $data): bool
    {
        try {
            $sql = "INSERT INTO page_visit_monitoring
                        (domain, causer_id, causer_type, link, method, payload, ip_address, user_agent, created_at, updated_at)
                    VALUES
                        (:domain, :causer_id, :causer_type, :link, :method, :payload, :ip_address, :user_agent, :created_at, :updated_at)";

            // Prepare the statement
            $stmt = $this->dbConnection()->prepare($sql);

            // Bind the parameters
            $stmt->bindValue(':domain', $data['domain']);
            $stmt->bindValue(':causer_id', $data['causer_id']);
            $stmt->bindValue(':causer_type', $data['causer_type']);
            $stmt->bindValue(':link', $data['link']);
            $stmt->bindValue(':method', $data['method']);
            $stmt->bindValue(':payload', $data['payload']);
            $stmt->bindValue(':ip_address', $data['ip_address']);
            $stmt->bindValue(':user_agent', $data['user_agent']);
            $stmt->bindValue(':created_at', $data['created_at']);
            $stmt->bindValue(':updated_at', $data['updated_at']);

            // Execute the query
            return $stmt->execute();
        } catch (PDOException $e) {
            // Handle query errors
            throw new PDOException("Insert failed: " . $e->getMessage());
        }
    }

    /**
     * Insert page visit monitoring data using PDO.
     *
     * @param array $data The data to insert
     * @return bool
     */
    private function insertActivityLogData(array $data): bool
    {
        try {
            $sql = "INSERT INTO activity_log_monitoring
            (domain, description, causer_type, causer_id, subject_type, subject_id, event_name, link, method, ip_address, user_agent, created_at, updated_at)
        VALUES
            (:domain, :description, :causer_type, :causer_id, :subject_type, :subject_id, :event_name, :link, :method, :ip_address, :user_agent, :created_at, :updated_at)";

            // Prepare the statement
            $stmt = $this->dbConnection()->prepare($sql);

            // Bind the values using bindValue
            $stmt->bindValue(':domain', $data['domain']); // Domain from the request
            $stmt->bindValue(':description', $data['description']); // Description
            $stmt->bindValue(':causer_type', $data['causer_type']); // User type
            $stmt->bindValue(':causer_id', $data['causer_id']); // User ID
            $stmt->bindValue(':subject_type', $data['subject_type']); // Model class
            $stmt->bindValue(':subject_id', $data['subject_id']); // Model primary key
            $stmt->bindValue(':event_name', $data['event_name']); // Event name
            $stmt->bindValue(':link', $data['link']); // Full URL from the request
            $stmt->bindValue(':method', $data['method']); // Request method (GET, POST, etc.)
            $stmt->bindValue(':ip_address', $data['ip_address']); // IP address
            $stmt->bindValue(':user_agent', $data['user_agent']); // User-Agent header
            $stmt->bindValue(':created_at', $data['created_at']); // Created at timestamp
            $stmt->bindValue(':updated_at', $data['updated_at']);

            // Execute the query
            return $stmt->execute();
        } catch (PDOException $e) {
            // Handle query errors
            throw new PDOException("Insert failed: " . $e->getMessage());
        }
    }
}
