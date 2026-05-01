# API Documentation v1.0

## Base URL
```
Local: http://localhost:8000/api
Production: https://volleytrack.app/api
```

## Authentication
Semua endpoint authenticated memerlukan Bearer Token dan header Content-Type: application/json

```bash
curl -X GET http://localhost:8000/api/user \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json"
```

---

## Endpoints

### 1. Teams Management

#### Get All User Teams
```http
GET /api/teams
Authorization: Bearer TOKEN
```

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Spike Masters",
      "plan_type": "pro",
      "players_count": 12,
      "created_at": "2025-05-01T10:00:00Z"
    }
  ]
}
```

---

### 2. Schedules Management

#### List Team Schedules
```http
GET /api/teams/{team_id}/schedules
Authorization: Bearer TOKEN
```

#### Create Schedule
```http
POST /api/teams/{team_id}/schedules
Authorization: Bearer TOKEN
Content-Type: application/json

{
  "title": "Latihan Reguler",
  "description": "Sesi latihan dengan fokus spike",
  "scheduled_at": "2025-05-02 19:00",
  "location": "Gelora Bung Karno"
}
```

---

### 3. Player Statistics

#### Add Player Statistic
```http
POST /api/statistics
Authorization: Bearer TOKEN
Content-Type: application/json

{
  "player_id": 1,
  "team_id": 1,
  "spike_count": 15,
  "block_count": 5,
  "ace_count": 3,
  "pass_accuracy": 85.5,
  "set_count": 8,
  "dig_count": 12
}
```

#### Get Player Statistics
```http
GET /api/players/{player_id}/statistics
Authorization: Bearer TOKEN
```

---

### 4. Leaderboard

#### Global Leaderboard
```http
GET /api/leaderboard?timeframe=all_time&page=1
Authorization: Bearer TOKEN
```

**Query Parameters:**
- `timeframe`: week, month, all_time (default: all_time)
- `page`: pagination (default: 1)
- `limit`: results per page (default: 50)

#### Team Leaderboard
```http
GET /api/teams/{team_id}/leaderboard
Authorization: Bearer TOKEN
```

---

### 5. Workouts

#### Get Recommended Workouts
```http
GET /api/workouts?difficulty=intermediate&limit=20
Authorization: Bearer TOKEN
```

**Query Parameters:**
- `difficulty`: beginner, intermediate, advanced
- `target_muscle`: legs, shoulders, core, arms, back
- `limit`: number of results
- `page`: pagination

---

### 6. External API Integration

#### Fetch Latest Workouts (Internal endpoint)
```http
POST /api/workouts/refresh
Authorization: Bearer TOKEN
```

**Note:** Trigger untuk fetch data dari ExerciseDB API dan simpan ke local database

---

## Error Responses

### 400 Bad Request
```json
{
  "message": "Validation failed",
  "errors": {
    "spike_count": ["The spike count must be an integer"]
  }
}
```

### 401 Unauthorized
```json
{
  "message": "Unauthenticated"
}
```

### 403 Forbidden
```json
{
  "message": "This action is unauthorized"
}
```

### 404 Not Found
```json
{
  "message": "Resource not found"
}
```

### 500 Internal Server Error
```json
{
  "message": "Internal server error",
  "error_id": "ERR_123456"
}
```

---

## Rate Limiting

- **Authenticated Users**: 1000 requests per hour
- **API Calls to External Services**: 100 requests per hour (cached)

Response headers include:
```
X-RateLimit-Limit: 1000
X-RateLimit-Remaining: 998
X-RateLimit-Reset: 1620000000
```

---

## WebHooks (Future Feature)

Planned untuk notifikasi real-time:
- Player stats uploaded
- Schedule updated
- Player ranked up/down

---

**Documentation Version**: 1.0  
**Last Updated**: May 1, 2025
