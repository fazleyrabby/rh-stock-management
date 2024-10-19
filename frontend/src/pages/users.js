import { useEffect, useState } from 'react';

export default function Users() {
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const apiUrl = process.env.API_BASE_URL;

  useEffect(() => {
    async function fetchUsers() {
      try {
        const res = await fetch(`${apiUrl}/api/users`); // Replace with your Laravel API endpoint
        const result = await res.json();

        console.log(result)
        if (result.success) {
          setUsers(result.data); // Users are in the `data` key
        } else {
          setError(result.message || 'Failed to fetch users.');
        }

        setLoading(false);
      } catch (error) {
        setError('Error fetching users');
        setLoading(false);
      }
    }

    fetchUsers();
  }, []);

  if (loading) {
    return <div>Loading...</div>;
  }

  if (error) {
    return <div>Error: {error}</div>;
  }

  return (
    <div>
      <h1>Users</h1>
      <ul>
        {users.map(user => (
          <li key={user.id}>{user.name}</li>
        ))}
      </ul>
    </div>
  );
}
