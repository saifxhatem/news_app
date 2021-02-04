Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'username-tool',
      path: '/username-tool',
      component: require('./components/Tool'),
    },
  ])
})
