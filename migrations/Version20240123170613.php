<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240123170613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE public.post (id UUID NOT NULL, title VARCHAR(255) NOT NULL, content TEXT NOT NULL,image VARCHAR(255) NULLABLE, author_id UUID default NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL , updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_885DBA6DA76ED395 ON public.post (id)');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE public.post');
    }
}
