# Task Management System

## Quick Start with Docker

```bash
# Clone repository
git clone https://github.com/sJonatas/task-management-system
cd task-management-system
```

# Start entire stack
```bash
docker-compose up -d
```

# Access application
* Frontend: http://localhost:3000
* Backend API: http://localhost:8000/api
* BE Healthcheck http://localhost:8000/up

Database: 

| Var Name | Value   |
|----------|---------|
| User     | user    |
| Password | passpwd |
| Port     | 3306    |

# API Endpoints

GET http://localhost:8000/api/tasks

> This endpoint returns all tasks registered.
> 
> The results are paginated, returning 10 records per page.
> 
> Sample response:
>

```json
{
  "response": {
    "current_page": 1,
    "data": [
      {
        "id": 1,
        "title": "Sample",
        "description": "-",
        "status": "pending",
        "priority": "medium",
        "dueDate": "2025-09-28",
        "created_at": "2025-09-28 00:00:00",
        "updated_at": "2025-09-28 00:00:00"
      }
    ],
    "first_page_url": "http://localhost:8000/api/tasks?page=1",
    "from": null,
    "last_page": 1,
    "last_page_url": "http://localhost:8000/api/tasks?page=1",
    "links": [
      {
        "url": null,
        "label": "&laquo; Previous",
        "page": null,
        "active": false
      },
      {
        "url": "http://localhost:8000/api/tasks?page=1",
        "label": "1",
        "page": 1,
        "active": true
      },
      {
        "url": null,
        "label": "Next &raquo;",
        "page": null,
        "active": false
      }
    ],
    "next_page_url": null,
    "path": "http://localhost:8000/api/tasks",
    "per_page": 10,
    "prev_page_url": null,
    "to": null,
    "total": 0
  },
  "status": 200
}
```

> You may navigate through the pages by defining the `page` attribute, e.g. `?page=3`.
> yet, it is possible to filter the results with the parameter `filter`, with a key value separated by pipe and 
> a comma separator for the filters. e.g. `?filter=title|som,description|som,created_at|2025`

GET http://localhost:8000/api/tasks/{id}

> This endpoint returns a specific task.
> 
> Response sample:

```json
{
    "task": {
        "id": 8949,
        "title": "Task sample 01",
        "description": "A brand new task ready to be executed!",
        "status": "pending",
        "priority": "medium",
        "dueDate": "2025-09-29 00:00:00",
        "createdAt": "2025-09-28T16:17:54.000000Z",
        "updatedAt": "2025-09-28T16:17:54.000000Z"
    },
    "status": 200
}
```

POST http://localhost:8000/api/tasks

> This endpoint creates a new task.
> 
> `Content-Type`: `application/json`
> 
> Request sample:

```json
{
    "title": "Task sample 01",
    "description": "A brand new task ready to be executed!",
    "status": "pending",
    "priority": "medium",
    "dueDate": "2025-09-29"
}
```

> Response sample:

```json
{
    "task": {
        "id": 9650,
        "title": "Task sample 01",
        "description": "A brand new task ready to be executed!",
        "status": "pending",
        "priority": "medium",
        "dueDate": "2025-09-29",
        "createdAt": "2025-09-28T17:38:33.000000Z",
        "updatedAt": "2025-09-28T17:38:33.000000Z"
    },
    "status": 201
}
```

PATCH http://localhost:8000/api/tasks/{id}

> This endpoint allows you to update a specific field of the task.
> 
> `Content-Type`: `application/json`
> 
> Sample request

```json
{
    "title": "patched value",
    "priority": "high"
}
```

> Sample response: 

```json
{
    "task": {
        "id": 8949,
        "title": "patched value",
        "description": "A brand new task ready to be executed!",
        "status": "pending",
        "priority": "high",
        "dueDate": "2025-09-29 00:00:00",
        "createdAt": "2025-09-28T16:17:54.000000Z",
        "updatedAt": "2025-09-28T16:18:13.000000Z"
    },
    "status": 200
}
```

DELETE http://localhost:8000/api/tasks/{id}

> This endpoint deletes a task. There is an empty response for it.

GET http://localhost:8000/api/tasks/stats

> This endpoint returns the tasks statistics.
> 
> Sample response:

```json
{
    "stats": {
        "totalTasks": 0,
        "byStatus": {
            "pending": 0,
            "in_progress": 0,
            "completed": 0
        },
        "byPriority": {
            "low": 0,
            "medium": 0,
            "high": 0
        }
    },
    "status": 200
}
```

**For easier and smooth testing, a Postman collection in provided in the api/docs folder.**

# Tests

To run the api tests, execute the `sh` file `./api/run-tests.sh`

The coverage report may be found at `/api/coverage`