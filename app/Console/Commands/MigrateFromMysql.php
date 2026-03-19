<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateFromMysql extends Command
{
    protected $signature = 'db:migrate-from-mysql';
    protected $description = 'Copy data from MySQL to PostgreSQL';

    public function handle(): void
    {
        $this->info('Starting MySQL → PostgreSQL data migration...');

        DB::connection('pgsql')->statement('SET session_replication_role = replica'); // disable FK checks

        $this->migrateUsers();
        $this->migrateSections();
        $this->migrateArticles();
        $this->migrateArticleBodies();
        $this->migrateComments();
        $this->migrateInvitations();
        $this->migrateSettings();

        DB::connection('pgsql')->statement('SET session_replication_role = DEFAULT');

        $this->resetSequences();

        $this->info('Migration complete!');
    }

    private function migrateUsers(): void
    {
        $this->info('Migrating users...');
        DB::connection('pgsql')->table('users')->truncate();

        $rows = DB::connection('mysql')->table('users')->get();
        foreach ($rows as $row) {
            DB::connection('pgsql')->table('users')->insert([
                'id'                => $row->id,
                'name'              => $row->name,
                'email'             => $row->email,
                'role'              => $row->role,
                'status'            => $row->status,
                'email_verified_at' => $row->email_verified_at,
                'notifications'     => $row->notifications,
                'password'          => $row->password,
                'remember_token'    => $row->remember_token,
                'created_at'        => $row->created_at,
                'updated_at'        => $row->updated_at,
            ]);
        }
        $this->info("  → {$rows->count()} users migrated.");
    }

    private function migrateSections(): void
    {
        $this->info('Migrating sections...');
        DB::connection('pgsql')->table('sections')->truncate();

        $rows = DB::connection('mysql')->table('sections')->get();
        foreach ($rows as $row) {
            DB::connection('pgsql')->table('sections')->insert([
                'id'      => $row->id,
                'section' => $row->section,
                'parent'  => $row->parent,
            ]);
        }
        $this->info("  → {$rows->count()} sections migrated.");
    }

    private function migrateArticles(): void
    {
        $this->info('Migrating articles...');
        DB::connection('pgsql')->table('articles')->truncate();

        $rows = DB::connection('mysql')->table('articles')->get();
        foreach ($rows as $row) {
            DB::connection('pgsql')->table('articles')->insert([
                'id'          => $row->id,
                'kb'          => $row->kb,
                'title'       => $row->title,
                'slug'        => $row->slug,
                'author'      => $row->author,
                'author_name' => $row->author_name,
                'sectionid'   => $row->sectionId,
                'tags'        => $row->tags,
                'attachments' => $row->attachments,
                'views'       => $row->views,
                'attachcount' => $row->attachCount,
                'scope'       => $row->scope,
                'images'      => $row->images,
                'rating'      => $row->rating,
                'approved'    => (bool) $row->approved,
                'published'   => (bool) $row->published,
                'notify_sent' => (bool) $row->notify_sent,
                'expires'     => $row->expires,
                'created_at'  => $row->created_at,
                'updated_at'  => $row->updated_at,
            ]);
        }
        $this->info("  → {$rows->count()} articles migrated.");
    }

    private function migrateArticleBodies(): void
    {
        $this->info('Migrating article bodies...');
        DB::connection('pgsql')->table('article_bodies')->truncate();

        $rows = DB::connection('mysql')->table('article_bodies')->get();
        foreach ($rows as $row) {
            DB::connection('pgsql')->table('article_bodies')->insert([
                'id'         => $row->id,
                'article_id' => $row->article_id,
                'body'       => $row->body,
            ]);
        }
        $this->info("  → {$rows->count()} article bodies migrated.");
    }

    private function migrateComments(): void
    {
        $this->info('Migrating comments...');
        DB::connection('pgsql')->table('comments')->truncate();

        $rows = DB::connection('mysql')->table('comments')->get();
        foreach ($rows as $row) {
            DB::connection('pgsql')->table('comments')->insert([
                'id'         => $row->id,
                'article_id' => $row->article_id,
                'user_id'    => $row->user_id,
                'rating'     => $row->rating,
                'comment'    => $row->comment,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
            ]);
        }
        $this->info("  → {$rows->count()} comments migrated.");
    }

    private function migrateInvitations(): void
    {
        $this->info('Migrating invitations...');
        DB::connection('pgsql')->table('invitations')->truncate();

        $rows = DB::connection('mysql')->table('invitations')->get();
        foreach ($rows as $row) {
            DB::connection('pgsql')->table('invitations')->insert([
                'id'          => $row->id,
                'email'       => $row->email,
                'name'        => $row->name,
                'message'     => $row->message,
                'signed_url'  => $row->signed_url,
                'invited_by'  => $row->invited_by,
                'expires_at'  => $row->expires_at,
                'accepted_at' => $row->accepted_at,
                'created_at'  => $row->created_at,
                'updated_at'  => $row->updated_at,
            ]);
        }
        $this->info("  → {$rows->count()} invitations migrated.");
    }

    private function migrateSettings(): void
    {
        $this->info('Migrating settings...');
        DB::connection('pgsql')->table('settings')->truncate();

        $rows = DB::connection('mysql')->table('settings')->get();
        foreach ($rows as $row) {
            DB::connection('pgsql')->table('settings')->insert([
                'id'           => $row->id,
                'invites'      => (bool) $row->invites,
                'full_text'    => (bool) $row->full_text,
                'editors'      => (bool) $row->editors,
                'email_toggle' => (bool) $row->email_toggle,
                'created_at'   => $row->created_at,
                'updated_at'   => $row->updated_at,
            ]);
        }
        $this->info("  → {$rows->count()} settings migrated.");
    }

    private function resetSequences(): void
    {
        $this->info('Resetting sequences...');
        $tables = ['users', 'articles', 'article_bodies', 'sections', 'comments', 'invitations', 'settings'];
        foreach ($tables as $table) {
            DB::connection('pgsql')->statement(
                "SELECT setval(pg_get_serial_sequence('{$table}', 'id'), COALESCE(MAX(id), 1)) FROM {$table}"
            );
        }
        $this->info('Sequences reset.');
    }
}
