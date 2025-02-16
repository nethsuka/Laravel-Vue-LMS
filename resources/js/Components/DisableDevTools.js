import { onMounted, onUnmounted } from 'vue'

export function usePreventDevTools() {
  // Prevent right click
  const handleContextMenu = (e) => {
    e.preventDefault()
    return false
  }

  // Prevent keyboard shortcuts
  const handleKeydown = (e) => {
    // Prevent F12
    if (e.keyCode === 123) {
      e.preventDefault()
      return false
    }

    // Prevent Ctrl+Shift+I/J/C
    if (e.ctrlKey && e.shiftKey && (e.keyCode === 73 || e.keyCode === 74 || e.keyCode === 67)) {
      e.preventDefault()
      return false
    }

    // Prevent Ctrl+U
    if (e.ctrlKey && e.keyCode === 85) {
      e.preventDefault()
      return false
    }
  }

  onMounted(() => {
    document.addEventListener('contextmenu', handleContextMenu)
    document.addEventListener('keydown', handleKeydown)
  })

  onUnmounted(() => {
    document.removeEventListener('contextmenu', handleContextMenu)
    document.removeEventListener('keydown', handleKeydown)
  })
}