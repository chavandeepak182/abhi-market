// --- Add these lines to routes/web.php, near the other agent.* routes
// (e.g. right after the /agent/today-leads route). Wrap them in
// 'isAdminAgent' middleware, same as other admin-only screens, so only
// admin/team-lead can change agent-region mapping.

Route::middleware('isAdminAgent')->group(function () {
    Route::get('/admin/agent-regions', [AgentController::class, 'regions'])
        ->name('agent.regions');

    Route::post('/admin/agent-regions', [AgentController::class, 'updateRegions'])
        ->name('agent.regions.update');

    // --- Agent management (list / create / edit / view leads / delete) ---
    Route::get('/admin/agents', [AgentController::class, 'index'])->name('agents.index');
    Route::get('/admin/agents/create', [AgentController::class, 'create'])->name('agents.create');
    Route::post('/admin/agents', [AgentController::class, 'store'])->name('agents.store');
    Route::get('/admin/agents/{id}', [AgentController::class, 'show'])->name('agents.show');
    Route::get('/admin/agents/{id}/edit', [AgentController::class, 'edit'])->name('agents.edit');
    Route::put('/admin/agents/{id}', [AgentController::class, 'update'])->name('agents.update');
    Route::delete('/admin/agents/{id}', [AgentController::class, 'destroy'])->name('agents.destroy');
});
