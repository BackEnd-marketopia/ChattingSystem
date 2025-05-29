<?php


namespace App\Repositories\Auth;

interface AuthRepositoryInterface
{
    /**
     * Interface for Auth Repository
     *
     * This interface defines the methods for user authentication and management.
    **/

    
    // Register a new user
    public function register(array $data);

    // Login a user with given credentials
    public function login(array $credentials);

    // Logout the currently authenticated user
    public function logout();

    // Get the currently authenticated user
    public function users();

    // Get user by ID
    public function show($userId);

    // Update user information
    public function update($userId, array $data);

    // Delete a user by ID
    public function delete($userId);
}
