
export interface Task {
    id: number|null,
    title: string,
    description: string|null,
    status: string,
    priority: string,
    dueDate: Date,
    created_at: Date,
    updated_at: Date
}