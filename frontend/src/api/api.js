const API_BASE = '/api/api'

export const api = {
  // Services
  getServices: async (params = {}) => {
    const query = new URLSearchParams(params).toString()
    const res = await fetch(`${API_BASE}/services.php?${query}`)
    const data = await res.json()
    return data.success ? data.data : []
  },

  createService: async (service) => {
    const res = await fetch(`${API_BASE}/services.php`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(service),
    })
    return res.json()
  },

  updateService: async (id, service) => {
    const res = await fetch(`${API_BASE}/services.php?id=${id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(service),
    })
    return res.json()
  },

  deleteService: async (id) => {
    const res = await fetch(`${API_BASE}/services.php?id=${id}`, {
      method: 'DELETE',
    })
    return res.json()
  },

  // Representatives
  getRepresentatives: async (district = '') => {
    const query = district ? `?district=${encodeURIComponent(district)}` : ''
    const res = await fetch(`${API_BASE}/reps.php${query}`)
    const data = await res.json()
    return data.success ? data : { data: [], districts: [] }
  },

  // Auth
  login: async (username, password) => {
    const res = await fetch(`${API_BASE}/auth.php`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ username, password }),
    })
    return res.json()
  },

  checkAuth: async () => {
    const res = await fetch(`${API_BASE}/auth.php`)
    return res.json()
  },

  logout: async () => {
    const res = await fetch(`${API_BASE}/auth.php`, {
      method: 'DELETE',
    })
    return res.json()
  },
}

