# ☁️ AWS Deployment Guide - VolleyTrack SaaS

**Course**: Cloud Computing Semester 6  
**Project**: VolleyTrack - Volleyball Management SaaS  
**Deployment Platform**: Amazon Web Services (AWS)  
**Architecture Type**: Multi-tier SaaS Application  

---

## 📋 Table of Contents

1. [Pre-Deployment Requirements](#pre-deployment-requirements)
2. [AWS Services Setup](#aws-services-setup)
3. [Environment Configuration](#environment-configuration)
4. [Database Migration](#database-migration)
5. [Application Deployment](#application-deployment)
6. [Monitoring & Logging](#monitoring--logging)
7. [Cost Optimization](#cost-optimization)
8. [Troubleshooting](#troubleshooting)

---

## 📌 Pre-Deployment Requirements

### ✅ Local Testing (MUST be completed first)
Before deploying to AWS, ensure:
- [ ] All 7 critical issues are fixed (see GITHUB_ISSUE_TESTING_RESULTS.md)
- [ ] `php artisan test` passes all tests
- [ ] `docker-compose up -d` works correctly
- [ ] Application accessible at `http://localhost:8000`
- [ ] Database migrations run successfully

### ✅ AWS Prerequisites
- [ ] AWS Account created with billing enabled
- [ ] AWS CLI installed and configured
  ```bash
  aws configure
  # Enter: AWS Access Key ID, Secret Access Key, Region (e.g., ap-southeast-1), Format (json)
  ```
- [ ] Docker installed locally for building images
- [ ] GitHub account for CI/CD (if using GitHub Actions)

### ✅ Code Requirements for AWS
- [ ] Dockerfile optimized for production (multi-stage build)
- [ ] Environment variables externalized (NO hardcoded secrets)
- [ ] `.env.production` template created
- [ ] Session driver set to `database` or `redis`
- [ ] Cache driver properly configured
- [ ] All database migrations tested

---

## 🏗️ AWS Services Setup

### Step 1: Create RDS MySQL Database

```bash
# Using AWS Console or AWS CLI
aws rds create-db-instance \
  --db-instance-identifier volleytrack-db \
  --db-instance-class db.t3.micro \
  --engine mysql \
  --engine-version 8.0 \
  --master-username admin \
  --master-user-password YourSecurePassword123! \
  --allocated-storage 20 \
  --vpc-security-group-ids sg-xxxxxxxx
```

**Configuration for RDS:**
- Engine: MySQL 8.0
- Instance Class: db.t3.micro (for development), db.t3.small+ for production
- Storage: 20 GB initial (auto-scaling enabled)
- Backup: 7-day retention
- Multi-AZ: Enabled for production
- Encryption: Enabled

**Network Configuration:**
- Create security group allowing inbound port 3306 from EC2 security group
- Create security group for EC2 allowing outbound to RDS security group

### Step 2: Create EC2 Instance

```bash
# Using AWS Console - Launch Instance
# Or using AWS CLI:
aws ec2 run-instances \
  --image-id ami-xxxxxxxxxx \  # Ubuntu 22.04 LTS
  --instance-type t3.small \
  --key-name my-key-pair \
  --security-group-ids sg-xxxxxxxx \
  --iam-instance-profile Name=VolleyTrackEC2Role
```

**EC2 Configuration:**
- AMI: Ubuntu 22.04 LTS
- Instance Type: t3.small (development), t3.medium+ (production)
- Volume: 30 GB EBS gp3
- Security Group: Allow ports 22 (SSH), 80 (HTTP), 443 (HTTPS)
- IAM Role: With S3 and ECR access

### Step 3: Setup S3 Bucket for Static Assets

```bash
# Create S3 bucket
aws s3 mb s3://volleytrack-assets-prod --region ap-southeast-1

# Enable versioning
aws s3api put-bucket-versioning \
  --bucket volleytrack-assets-prod \
  --versioning-configuration Status=Enabled

# Block public access (use CloudFront instead)
aws s3api put-public-access-block \
  --bucket volleytrack-assets-prod \
  --public-access-block-configuration \
    BlockPublicAcls=true,IgnorePublicAcls=true,BlockPublicPolicy=true,RestrictPublicBuckets=true
```

### Step 4: Create CloudFront Distribution

**CloudFront Configuration:**
- Origin: S3 bucket (volleytrack-assets-prod)
- Distribution Type: Web
- HTTPS: Enabled (ACM certificate)
- Cache Policy: Managed-CachingOptimized
- Origin Request Policy: CORS-S3Origin

### Step 5: Setup Route 53 DNS (Optional - if using custom domain)

```bash
# Create hosted zone
aws route53 create-hosted-zone \
  --name volleytrack.example.com \
  --caller-reference $(date +%s)

# Create A record pointing to ALB
aws route53 change-resource-record-sets \
  --hosted-zone-id Z1234567890ABC \
  --change-batch file://dns-record.json
```

---

## 🔐 Environment Configuration

### Step 1: Create AWS Secrets Manager Secret

```bash
# Create secret for production environment
aws secretsmanager create-secret \
  --name volleytrack/production \
  --description "VolleyTrack Production Environment Variables" \
  --secret-string '{
    "APP_KEY": "base64:YOUR_ENCRYPTED_KEY",
    "DB_HOST": "volleytrack-db.xxxxx.ap-southeast-1.rds.amazonaws.com",
    "DB_USERNAME": "admin",
    "DB_PASSWORD": "YourSecurePassword123!",
    "DB_DATABASE": "volleytrack_db",
    "CACHE_DRIVER": "redis",
    "REDIS_HOST": "volleytrack-redis.xxxxx.cache.amazonaws.com",
    "SESSION_DRIVER": "database",
    "AWS_ACCESS_KEY_ID": "AKIAIOSFODNN7EXAMPLE",
    "AWS_SECRET_ACCESS_KEY": "wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY",
    "AWS_DEFAULT_REGION": "ap-southeast-1",
    "AWS_BUCKET": "volleytrack-assets-prod"
  }'
```

### Step 2: Create .env.production File

```env
APP_NAME="VolleyTrack SaaS"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://volleytrack.example.com

LOG_CHANNEL=cloudwatch
LOG_LEVEL=info

DB_CONNECTION=mysql
DB_HOST=${DB_HOST}
DB_PORT=3306
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}

SESSION_DRIVER=database
SESSION_LIFETIME=120

CACHE_DRIVER=redis
CACHE_STORE=redis
REDIS_HOST=${REDIS_HOST}
REDIS_PORT=6379

QUEUE_CONNECTION=redis

FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=${AWS_ACCESS_KEY_ID}
AWS_SECRET_ACCESS_KEY=${AWS_SECRET_ACCESS_KEY}
AWS_DEFAULT_REGION=${AWS_DEFAULT_REGION}
AWS_BUCKET=${AWS_BUCKET}

MAIL_MAILER=ses
AWS_SES_REGION=${AWS_DEFAULT_REGION}

SANCTUM_STATEFUL_DOMAINS=volleytrack.example.com
```

### Step 3: Create IAM Role for EC2

```bash
# Inline policy for EC2 instance
cat > iam-policy.json <<EOF
{
  "Version": "2012-10-17",
  "Statement": [
    {
      "Effect": "Allow",
      "Action": [
        "s3:*"
      ],
      "Resource": "arn:aws:s3:::volleytrack-assets-prod/*"
    },
    {
      "Effect": "Allow",
      "Action": [
        "ecr:GetAuthorizationToken",
        "ecr:BatchGetImage",
        "ecr:GetDownloadUrlForLayer"
      ],
      "Resource": "*"
    },
    {
      "Effect": "Allow",
      "Action": [
        "logs:CreateLogGroup",
        "logs:CreateLogStream",
        "logs:PutLogEvents"
      ],
      "Resource": "arn:aws:logs:*:*:*"
    },
    {
      "Effect": "Allow",
      "Action": [
        "secretsmanager:GetSecretValue"
      ],
      "Resource": "arn:aws:secretsmanager:*:*:secret:volleytrack/*"
    }
  ]
}
EOF
```

---

## 🗄️ Database Migration

### Step 1: Connect to EC2

```bash
# SSH into EC2
ssh -i your-key.pem ubuntu@your-ec2-public-ip

# Update system
sudo apt update && sudo apt upgrade -y

# Install required packages
sudo apt install -y docker.io docker-compose php php-cli php-fpm mysql-client git
```

### Step 2: Clone Application

```bash
# Clone from GitHub (or copy via S3)
git clone https://github.com/yourusername/volleytrack.git
cd volleytrack

# Set permissions
sudo chown -R ubuntu:ubuntu .
chmod -R 755 ./
```

### Step 3: Run Migrations on RDS

```bash
# Load environment from AWS Secrets Manager
export $(aws secretsmanager get-secret-value \
  --secret-id volleytrack/production \
  --query SecretString \
  --output text | jq -r 'to_entries | .[] | "\(.key)=\(.value)"')

# Run migrations
php artisan migrate --force

# Seed data (if needed)
php artisan db:seed --class=DatabaseSeeder
```

---

## 🚀 Application Deployment

### Step 1: Build Docker Image

```bash
# Build optimized Docker image
docker build -t volleytrack:latest -f Dockerfile .

# Tag for ECR
docker tag volleytrack:latest ACCOUNT_ID.dkr.ecr.ap-southeast-1.amazonaws.com/volleytrack:latest
```

### Step 2: Push to Amazon ECR

```bash
# Login to ECR
aws ecr get-login-password --region ap-southeast-1 | docker login --username AWS --password-stdin ACCOUNT_ID.dkr.ecr.ap-southeast-1.amazonaws.com

# Push image
docker push ACCOUNT_ID.dkr.ecr.ap-southeast-1.amazonaws.com/volleytrack:latest
```

### Step 3: Setup Application Server

**Option A: Using Docker on EC2**

```bash
# Create docker-compose.prod.yml
# Deploy with:
docker-compose -f docker-compose.prod.yml up -d
```

**Option B: Using AWS App Runner** (Recommended for SaaS)

```bash
# Configure App Runner via AWS Console:
# 1. Source: ECR image
# 2. Port: 8000 or 80
# 3. Environment variables: Load from Secrets Manager
# 4. Auto-scaling: Min 1, Max 3 instances
# 5. Health check: /health endpoint
```

### Step 4: Configure Nginx/Load Balancer

```nginx
# /etc/nginx/sites-available/volleytrack
server {
    listen 80;
    server_name volleytrack.example.com www.volleytrack.example.com;
    
    # Redirect HTTP to HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name volleytrack.example.com;
    
    ssl_certificate /etc/letsencrypt/live/volleytrack.example.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/volleytrack.example.com/privkey.pem;
    
    location / {
        proxy_pass http://127.0.0.1:8000;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
    
    # Static assets from S3/CloudFront
    location ~* \.(jpg|jpeg|png|gif|css|js|ico|svg)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
```

---

## 📊 Monitoring & Logging

### Step 1: Setup CloudWatch Logging

```php
// config/logging.php - Add CloudWatch channel
'cloudwatch' => [
    'driver' => 'monolog',
    'handler' => \Aws\CloudWatch\CloudWatchClient::class,
    'handler_with' => [
        'group' => '/aws/volleytrack/laravel',
        'stream' => 'production',
    ],
],
```

### Step 2: Enable CloudWatch Agent

```bash
# Install CloudWatch agent
wget https://s3.amazonaws.com/amazoncloudwatch-agent/ubuntu/amd64/latest/amazon-cloudwatch-agent.deb
sudo dpkg -i -E ./amazon-cloudwatch-agent.deb

# Configure agent
sudo /opt/aws/amazon-cloudwatch-agent/bin/amazon-cloudwatch-agent-config-wizard

# Start agent
sudo systemctl start amazon-cloudwatch-agent
```

### Step 3: Create CloudWatch Alarms

```bash
# CPU Utilization Alarm
aws cloudwatch put-metric-alarm \
  --alarm-name volleytrack-cpu-high \
  --alarm-description "Alert when CPU > 80%" \
  --namespace AWS/EC2 \
  --metric-name CPUUtilization \
  --threshold 80 \
  --comparison-operator GreaterThanThreshold \
  --alarm-actions arn:aws:sns:ap-southeast-1:ACCOUNT_ID:VolleyTrackAlerts

# RDS Database Connections
aws cloudwatch put-metric-alarm \
  --alarm-name volleytrack-db-connections-high \
  --alarm-description "Alert when DB connections > 80" \
  --namespace AWS/RDS \
  --metric-name DatabaseConnections \
  --threshold 80 \
  --comparison-operator GreaterThanThreshold
```

---

## 💰 Cost Optimization

### Recommended Configuration for Production SaaS

```
Monthly Cost Estimate (Low Traffic):

EC2 t3.small:           ~$15-20/month
RDS db.t3.micro:        ~$25-30/month
CloudFront:             ~$5-15/month (depends on traffic)
S3:                     ~$5-10/month
NAT Gateway:            ~$32/month (optional)
Data Transfer:          ~$5-15/month

Total: ~$90-120/month for low traffic SaaS
```

### Cost Optimization Tips

1. **Use Reserved Instances** for 1-3 year commitment (save 40%)
2. **Auto-Scaling** - Scale down during off-peak hours
3. **S3 Lifecycle Policies** - Archive old data to Glacier
4. **CloudFront Caching** - Reduce S3 requests
5. **RDS Read Replicas** - For high read traffic
6. **Use Graviton2 Processors** - Save 20% vs x86

---

## 🔧 Troubleshooting

### Issue: Database Connection Timeout

```bash
# Check security group rules
aws ec2 describe-security-groups --group-ids sg-xxxxx

# Test connectivity
mysql -h volleytrack-db.xxxxx.rds.amazonaws.com -u admin -p -e "SELECT 1"
```

### Issue: Application Not Responding

```bash
# Check EC2 instance logs
tail -f storage/logs/laravel.log

# Check Docker containers
docker ps -a
docker logs container-id

# Restart application
docker-compose restart laravel
```

### Issue: High CPU/Memory Usage

```bash
# Monitor CloudWatch metrics
aws cloudwatch get-metric-statistics \
  --namespace AWS/EC2 \
  --metric-name CPUUtilization \
  --dimensions Name=InstanceId,Value=i-xxxxxx \
  --start-time 2024-05-01T00:00:00Z \
  --end-time 2024-05-05T00:00:00Z \
  --period 300 \
  --statistics Average
```

---

## ✅ Deployment Checklist

Before going live, verify:

- [ ] All code issues from GITHUB_ISSUE_TESTING_RESULTS.md are fixed
- [ ] RDS MySQL database is running and accessible
- [ ] EC2 instance is configured with proper security groups
- [ ] CloudFront distribution is created and working
- [ ] SSL/TLS certificate is installed
- [ ] Database migrations have run successfully
- [ ] Application is accessible via public IP/domain
- [ ] CloudWatch logging is enabled
- [ ] Automated backups are configured
- [ ] Monitoring alarms are set up
- [ ] Load testing completed (JMeter/Artillery)
- [ ] Security audit completed (no SQL injection, XSS vulnerabilities)
- [ ] Performance is acceptable (<1s response time)

---

## 📚 Additional Resources

- [AWS RDS Best Practices](https://docs.aws.amazon.com/AmazonRDS/latest/UserGuide/CHAP_BestPractices.html)
- [Laravel on AWS](https://docs.laravel.com/deployment/aws-lambda)
- [AWS Well-Architected Framework](https://aws.amazon.com/architecture/well-architected/)
- [SaaS Architecture Best Practices](https://aws.amazon.com/blogs/enterprise-strategy/what-is-saas/)

---

**Last Updated**: May 5, 2026  
**Course**: Cloud Computing - Semester 6  
**Status**: Ready for Implementation

