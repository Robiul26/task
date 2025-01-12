import React from 'react'
import { Outlet } from 'react-router-dom'

export default function GuestLayout() {


  return (
    <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'center', paddingTop: '30px' }} >
      <main style={{ width: '70%' }}>
        <Outlet />
      </main>
    </div>
  )
}
