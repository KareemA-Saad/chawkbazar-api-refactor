## Current Phase: Public Endpoints 🚧 IN PROGRESS

### Phase 1: Super Admin Role (DONE)
- [x] Business rules & flow documentation
- [x] User Management endpoints (7: CRUD, ban/activate, addPoints, makeAdmin)
- [x] Type/Category/Tag management (already done)
- [x] Author/Manufacturer management (already done)
- [x] Shop approval endpoints (3: approve, disapprove, new-shops)
- [x] Withdrawal approval endpoints (2: delete, approve)
- [x] Settings management (1: store)
- [x] Tax management (5: full CRUD)
- [x] Shipping management (5: full CRUD)
- [x] Refund management (2: update, delete)
- [x] Abuse reports management (5: index, show, destroy, accept, reject)
- [x] Flash sale approvals (2: approve, disapprove)
- [x] Coupon approvals (2: approve, disapprove)
- [x] Code review (fixed update() return, addPoints return)
- [x] Swagger regeneration & verification
- [ ] Testing all endpoints (ready for manual testing)

### Phase 2: Editor Role ✅ COMPLETE
- [x] CMS page management (5 endpoints: index, show, store, update, destroy) [EDITOR, SUPER_ADMIN]
- [x] Puck page builder (2 endpoints: showByPath, storePuckPage) [EDITOR, SUPER_ADMIN]
- [x] All endpoints already documented with role permissions noted

### Phase 3: Store Owner Role ✅ COMPLETE
- [x] Reference: [roles_endpoints_reference.md](roles_endpoints_reference.md) (Store Owner Column)
- [x] **Products**: Verify ProductController coverage (Create, Update, Delete).
- [x] **Orders**: Document OrderController (Index, Show, Update Status).
- [x] **Withdrawals**: Document WithdrawController (Request, View).
- [x] **Shops & Staff**: Document ShopController (Staff management).
- [x] **Attributes**: Document attributes management.
- [x] **Questions & Reviews**: Document Q&A and Reviews.
- [x] Generate & Verify Swagger.

### Phase 4: Staff Role ✅ COMPLETE
- [x] Analytics endpoints (Swagger Documentation)
- [x] FAQ management (Swagger Documentation)
- [x] Store Notices (Swagger Documentation)
- [x] Product Stock & Drafts (Swagger Documentation)
- [x] Coupon Update (Swagger Documentation)
- [ ] Testing

### Phase 5: Customer Role ✅ COMPLETE
- [x] Profile management
- [x] Order endpoints
- [x] Review/Question endpoints
- [x] Wishlist endpoints
- [x] Refund request endpoints
- [x] Conversation/messaging
- [ ] Testing

### Phase 6: Public Endpoints
- [ ] Remaining public GET endpoints
- [ ] Order creation endpoint
- [ ] Testing
