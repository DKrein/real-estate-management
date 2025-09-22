# real-estate-management

## About Project

Our clients operate in the real estate sector, managing multiple buildings within their accounts. We need to provide a tool that allows our owners to create tasks for their teams to perform within each building and add comments to their tasks for tracking progress.. These tasks should be assignable to any team member and have statuses such as Open, In Progress, Completed, or Rejected. 

## Getting Started

### Clone the project

```bash
git clone git@github.com:DKrein/real-estate-management.git && \
cd real-estate-management
```

### Start the docker

```bash
docker compose up -d --build
```

### Install dependencies

```bash
docker exec -it proprli_app composer install
```

### Rodar seeders

```bash
docker exec -it proprli_app php artisan migrate:fresh --seed
```

## APIS

### Buildings

List all buildings

GET `/api/buildings`
Response example:
```bash
[
  {
    "id": 1,
    "name": "Building A",
    "address": "123 Main St"
  }
]
```

Show building with tasks and comments

GET `/api/buildings/{building}`
Query parameters for filtering tasks (optional):
- status (string) – filter tasks by status (open, in_progress, completed, rejected)
- assigned_user_id (integer) – filter tasks by assigned user
- created_from (date, YYYY-MM-DD) – filter tasks created after this date
- created_to (date, YYYY-MM-DD) – filter tasks created before this date

Response example:
```bash
{
  "id": 1,
  "name": "Building A",
  "address": "123 Main St",
  "tasks": [
    {
      "id": 1,
      "title": "Fix the lights",
      "description": "Replace bulbs in Room 101",
      "status": "open",
      "assigned_user_id": 5,
      "unit_id": null,
      "created_at": "2025-09-21T12:00:00Z",
      "comments": [
        {
          "id": 1,
          "user_id": 2,
          "content": "I will handle this tomorrow",
          "created_at": "2025-09-21T13:00:00Z"
        }
      ]
    }
  ]
}
```
List all units of a building

GET `/api/buildings/{building}/units`

List all tasks of a building

GET `/api/buildings/{building}/tasks`

### Tasks

List all tasks

GET `/api/tasks`

Create a new task

POST `/api/tasks`
Payload example (StoreTaskRequest):
```bash
{
  "building_id": 1,
  "unit_id": 2,
  "assigned_user_id": 5,
  "title": "Fix the lights",
  "description": "Replace bulbs in Room 101",
  "status": "open"
}
```

### Comments
Create a comment for a task

POST `/api/tasks/{task}/comments`
Payload example (StoreCommentRequest):
```bash
{
  "task_id": 1,
  "user_id": 2,
  "content": "I will handle this tomorrow"
}
```