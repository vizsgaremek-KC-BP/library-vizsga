export interface User {
	message: string,
	token: string,
	user: {
		id: string,
		name: string,
		email: string,
		edu_id: string,
		role: string,
		created_at: string,
		updated_at: string
	}
}