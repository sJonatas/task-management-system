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

POST http://localhost:8000/api/tasks
PATCH http://localhost:8000/api/tasks
DELETE http://localhost:8000/api/tasks