
# Superorganics Example CRM B2B

A brief description of what this project does and who it's for


## Part 1 — Debug & Review 

Answer the following:

1. What performance problem exists in this code? 
   The code suffers from the N+1 query problem.

    - It first runs 1 query to fetch all leads.
    - Then, for each lead, it runs an additional query to fetch the related user.
    Impact:
    - If there are 100 leads → 101 queries
    - If there are 10,000 leads → 10,001 queries

    This leads to:

    - High database load
    - Increased latency
    - Poor scalability 

2. How would you fix it in Laravel?
Use a JOIN (Query Builder)
```php
    public function index(): Response
    {
        $leads = DB::table('leads')
            ->leftJoin('users', 'users.id', '=', 'leads.assigned_user_id')
            ->select('leads.*', 'users.name as user_name', 'users.email as user_email')
            ->get();

        return response()->json($leads);
    }
``` 
- Executes a single query
- Efficient for simple data retrieval 

### Or
Use Eloquent with Eager Loading

Define the relationship in the Lead model:

```php
    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }
```
then 
```php
    public function index()
    {
        $leads = Lead::with('user')->get();

        return response()->json($leads);
    }
```

3. If the table grows to 1M leads, what database changes would you consider?

### Indexing (Critical)

```sql
CREATE INDEX idx_assigned_user_id ON leads(assigned_user_id);
```
- Speeds up joins and lookups

### Pagination strategy

```php
    public function index(): Response
    {
        $leads = Lead::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return Inertia::render('Leads/Index', [
            'leads' => $leads,
        ]);
    }
```
## Caching

- Use Redis to cache frequent queries
- Cache commonly accessed relationships

```php
    public function index(): Response
    {
        $leads = Cache::remember('leads', 60, function () {
            return Lead::with('user')
                ->orderBy('created_at', 'desc')
                ->paginate(12);
        });

        return Inertia::render('Leads/Index', [
            'leads' => $leads,
        ]);
    }
```
## Partitioning

- Partition by created_at or another logical key
- Improves performance at scale

whit laravel 

```php
    Lead::with('user')->chunk(1000, function ($leads) {
    // process data
    }); 
```

whit sql 

```sql
CREATE TABLE leads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    email VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
) PARTITION BY RANGE (YEAR(created_at)) (
    PARTITION p2023 VALUES LESS THAN (2024),
    PARTITION p2024 VALUES LESS THAN (2025),
    PARTITION p2025 VALUES LESS THAN (2026),
    PARTITION p2026 VALUES LESS THAN (2027)
);
```

## Part 2 —  Data Modeling 

Table: lead_notes 

```sql
CREATE TABLE lead_notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lead_id INT,
    user_id INT,
    note TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (lead_id) REFERENCES leads(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```
## Explanation: 

- lead_id → which lead the note belongs to
- user_id → which sales rep created the note
- note → the actual content
- timestamps → audit trail (important in CRM systems)

Indexes:

```sql
INDEX idx_lead_id (lead_id)
INDEX idx_lead_created_at (lead_id, created_at DESC)
INDEX idx_user_id (user_id) 
```

why 

- lead_id → fast lookup of notes per lead
- (lead_id, created_at) → efficient retrieval of latest notes
- user_id → filtering by sales rep

# Part 3 Feature Implemntation

## API Endpoint

POST /api/leads/{lead}/notes
Body: { "note": "Buyer wants to review wholesale pricing." }

# Returns 201:
{
  "message": "Note created successfully.",
  "data": { id, lead_id, user_id, note, user: {id, name, email}, created_at, updated_at }
}

## Web Route

Route::post('/leads/{lead}/notes', [LeadNoteController::class, 'store'])
    ->name('leads.notes.store');

## Explanation:

- POST /api/leads/{lead}/notes → POST request to the API endpoint
- Body: { "note": "Buyer wants to review wholesale pricing." } → JSON body with the note content
- Returns 201 → HTTP status code 201 Created
- { id, lead_id, user_id, note, user: {id, name, email}, created_at, updated_at } → JSON response with the created note and related user data

## Part 4 Engineering Thinking


1) What would you improve next?

*Query optimization
 - Enforce pagination (cursorPaginate)
 - Add composite indexes (lead_id, created_at, assigned_user_id)
 - Avoid SELECT *

*Architecture
 - Introduce read replicas for heavy read traffic
 - Use queue workers (emails, notifications, enrichment jobs)

*Caching
 - Cache frequent queries (e.g., dashboards, lead lists) with Redis

*Data access patterns
 - Precompute aggregates (e.g., latest note, lead status)
 - Consider denormalization for hot fields

*Scalability
- Use chunking / lazy loading for large operations
- Add API rate limiting and monitoring

2) Where could AI automation help this CRM?

*Lead scoring
- Predict conversion probability based on activity and attributes

*Auto-generated notes
- Summarize calls/emails into structured notes

*Smart follow-ups
- Suggest next actions (e.g., “send pricing”, “schedule demo”)

*Email automation
- Generate personalized outreach messages

*Data enrichment
- Auto-fill company info, industry, size, etc.

*Sentiment analysis
- Detect intent/interest level from notes or conversations
