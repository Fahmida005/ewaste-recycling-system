# Initial Project Upload
# ewaste-recycling-system

erDiagram
    USERS ||--o{ REQUESTS : places
    USERS ||--|| REWARDS : earns
    RECYCLING_CENTERS ||--o{ REQUESTS : receives

    USERS {
        int id PK
        string name
        string email UK
        string phone
        string password
        enum role
        datetime created_at
    }

    ADMIN {
        int id PK
        string username UK
        string password
    }

    RECYCLING_CENTERS {
        int center_id PK
        string center_name
        text address
        string phone
    }

    REQUESTS {
        int request_id PK
        int user_id FK
        string waste_type
        int quantity
        text address
        date request_date
        enum status
        int center_id FK
    }

    REWARDS {
        int reward_id PK
        int user_id FK
        int points
    }
