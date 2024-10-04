Here are all the API endpoints from your code in a list format, categorized by user roles:

1. Authentication Endpoints
POST /login: User login
GET /me: Get authenticated user details

2. Admin Routes (Managing Trainers and Classes)
(Requires auth:api and role:Admin middleware)

GET /admin/trainers: Get all trainers

POST /admin/trainers: Add a new trainer

PUT /admin/trainers/{id}: Update a trainer's information

DELETE /admin/trainers/{id}: Delete a trainer

GET /admin/classes: Get all classes

POST /admin/classes: Add a new class

3. Trainer Routes (Assigned Classes)
(Requires auth:api and role:Trainer middleware)

GET /trainer/classes: View assigned classes

4. Trainee Routes (Profile Management and Class Booking)
(Requires auth:api and role:Trainee middleware)

GET /trainee/bookings: View trainee's bookings
POST /trainee/bookings: Book a class
DELETE /trainee/bookings/{id}: Cancel a booking

This is the list of all the endpoints in your API categorized by user role

and this is not 3days project
